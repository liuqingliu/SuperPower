<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/6
 * Time: 11:21
 */

namespace App\Listeners;


use App\Events\SendWulian;
use App\Jobs\CalculateIncome;
use App\Jobs\SendTemplateMsg;
use App\Mail\CommonError;
use App\Models\ChargingEquipment;
use App\Models\ElectricCard;
use App\Models\EquipmentPort;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Eletric;
use App\Models\Logic\Snowflake;
use App\Models\RechargeOrder;
use App\Models\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MsnEventSubscriber
{
    /**
     * 上报信息
     * @translator laravelacademy.org
     */
    public function register($event)
    {
        //查询设备表，是否有该设备
        $deviceInfo = ChargingEquipment::where("equipment_id", $event->devid)->where("equipment_status",
            Eletric::DEVICE_STATUS_ACTIVE)->first();
        $answer = [
            "func" => "register",
            "ret" => "ok",
        ];
        if (empty($deviceInfo)) {
            $answer["ret"] = "failed";
            try {
                event(new SendWulian($event->devid, $answer));
            } catch (\Exception $e) {
                Log::info("sendwulian-error:" . serialize($e->getMessage()));
            }
            return;
        }
        //更新设备信息
        $deviceInfo->board_info = json_encode([
            "board1" => $event->board1,
            "board2" => $event->board2,
            "board3" => $event->board3
        ]);
        $res = $deviceInfo->save();
        if (!$res) {
            Log::info("save_device_info:" . serialize($event));
            return;
        }

        //如果有设备三块板子都有问题，则报警
        if ($event->board1 == "N" && $event->board2 == "N" && $event->board3 == "N") {
            $errmsg = [
                "adr" => __METHOD__ . "," . __FUNCTION__,
                "desc" => "有设备三个板子都坏了！！！设备编号：" . $event->devid,
                "detail" => serialize($event),
            ];
            Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
        }
        event(new SendWulian($event->devid, $answer));
    }

    /**
     * 同步订单
     */
    public function sync($event)
    {
        $orderList = RechargeOrder::where("equipment_id", $event->devid)
            ->where("recharge_status", Charge::ORDER_RECHARGE_STATUS_CHARGING)
            ->where("created_at", ">", date("Y-m-d", strtotime("-12 hours")))
            ->get();
        $answer = [
            "ret" => "ok",
            "func" => "sync",
            "data" => "",
        ];
        //订单号16B+端口号2B(不足2B补齐)+可用时间5B ==23B
        //如20180829000000010110010,表示订单2018082900000001在1号端口，可以时间10010秒。
        //如果以后订单超过16b限制，则这里也需要修改，慎重！！
        foreach ($orderList as $order) {
            $tmp = $order->order_id . Common::getPrexZero($order->port,
                    2) . Common::getLeftTime($order->recharge_total_time, $order->created_at);
            $answer["data"] .= $tmp;
        }
        //        $fp = fopen('somefile.txt', 'r');

// read some data
// move back to the beginning of the file
//// same as rewind($fp);
//        fseek($fp, 2);
//        $ss = fread($fp,5);
        event(new SendWulian($event->devid, $answer));
        if ($event->version != Eletric::DEVICE_VERSION) {
            $upgrade = [
                "func" => "upgrade",
                "version" => (int)Eletric::DEVICE_VERSION,
                "size" => (int)Eletric::DEVICE_VERSION_SIZE,
                "md5" => Eletric::DEVICE_VERSION_MD5
            ];
            event(new SendWulian($event->devid, $upgrade));
        }
    }

    /**
     * 电卡刷卡，下位机请求三次
     */
    public function card_request($event)
    {
        //如果有端口没加进来
        $deviceInfo = ChargingEquipment::where("equipment_id", $event->devid)->first();
        if (empty($deviceInfo) || empty($deviceInfo->equipmentports)) {
            return;
        }
        $cardInfo = ElectricCard::where("card_id", $event->cardId)->first();
        $answer = [
            "func" => "card_charge",
            "order" => "",
            "cmd" => "open",// open或refuse
            "port" => $event->port,
            "cause" => "", //block,未激活(不存在)； insuffic,余额不足，porterr,端口不可用
            "cash" => 0,
            "left_time" => 0
        ];
        if (empty($cardInfo) || $cardInfo->card_status == Eletric::CARD_STATUS_FROZEN) {
            $answer["cause"] = "block";
            $answer["cmd"] = "refuse";
            event(new SendWulian($event->devid, $answer));//下发3次，直到有回复过来
            return;
        }

        if ($cardInfo->money < 200) {//小于2元
            $answer["cause"] = "insuffic";
            $answer["cmd"] = "refuse";
        }
        //查询当前设备和port
        DB::beginTransaction();
        try {
            $portInfo = EquipmentPort::where("equipment_id", $event->devid)->where("port",
                $event->port)->lockForUpdate()->first();
            if ($portInfo->status == Eletric::PORT_STATUS_USE) {
                $answer["cause"] = "porterr";
                $answer["cmd"] = "refuse";
            }
            $orderId = Snowflake::nextId();
            if ($answer["cmd"] == "open") {
                //创建订单,设置port为不可用
                $minTime = min(6 * Common::ONE_HOUR_SECONDES,
                    $cardInfo->money * $deviceInfo->charging_unit_second);
                Log::info("card_request:".$minTime.",cardinfo=".$cardInfo->money.",device_unit=".$deviceInfo->charging_unit_second);
                $orderInfo = [
                    "order_id" => $orderId,
                    "recharge_str" => $event->cardId,
                    "equipment_id" => $event->devid,
                    "port" => $event->port,
                    "recharge_unit_second" => $deviceInfo->charging_unit_second,
                    "type" => Charge::ORDER_RECHARGE_TYPE_CARD,
                    "created_at" => date("Y-m-d H:i:s"),
                    "recharge_total_time" => $minTime,
                ];
                $answer["left_time"] = $minTime;
                RechargeOrder::insert($orderInfo);
                $portInfo->status = Eletric::PORT_STATUS_USE;
                $portInfo->save();
            }
            $answer["order"] = "{$orderId}";
            $answer["cash"] = $cardInfo->money;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();//事务回滚
            Log::info(__CLASS__ . __FUNCTION__ . ",event=" . serialize($event));
        }

        event(new SendWulian($event->devid, $answer));//下发3次，直到有回复过来
//        return;
//        Charge::sendWulianThree($event->devid, $answer);
    }

    /**
     * 电卡充电请，开始计费
     */
    public function card_charge($event)
    {
        DB::beginTransaction();
        try {
            $rechargeOrder = RechargeOrder::where("order_id", $event->order)->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_DEFAULT)->lockForUpdate()->first();
            if ($event->ret == "ok") {
                if (!empty($rechargeOrder)) {
                    $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_CHARGING;
                    $rechargeOrder->save();
                }
            } else {
                if ($event->ret == "failed") {//关闭订单
                    if (!empty($rechargeOrder)) {
                        $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_FAILED;
                        $rechargeOrder->save();
                        $portInfo = EquipmentPort::where("equipment_id",
                            $rechargeOrder->equipment_id)->where("port", $rechargeOrder->port)->first();
                        $portInfo->status = Eletric::PORT_STATUS_DEFAULT;
                        $portInfo->save();
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();//事务回滚
            Log::info(__FUNCTION__ . "-event:" . serialize($event));
        }
    }

    /**
     * 充电结束
     * 推消息
     */

    public function charge_finish($event)
    {
        $answer = [
            "func" => "charge_finish",
            "order" => $event->order,
            "ret" => "ok",
        ];
        $rechargeOrder = RechargeOrder::where("order_id", $event->order)->first();
        if (!empty($rechargeOrder)) {
            if ($rechargeOrder->recharge_status != Charge::ORDER_RECHARGE_STATUS_END) {
                try {
                    DB::transaction(function () use ($rechargeOrder) {
                        $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_END;
                        $rechargeOrder->recharge_end_time = date("Y-m-d H:i:s");
                        $rechargeOrder->recharge_price = ceil(time() - strtotime($rechargeOrder->created_at)) / ($rechargeOrder->recharge_unit_second);
                        $rechargeOrder->save();
                        $portInfo = EquipmentPort::where("equipment_id", $rechargeOrder->equipment_id)->where("port",
                            $rechargeOrder->port)->first();
                        $portInfo->status = 0;
                        $portInfo->save();
                        if ($rechargeOrder->type == Charge::ORDER_RECHARGE_TYPE_USER) {
                            $userInfo = User::where("openid", $rechargeOrder->recharge_str)->first();
                            $userInfo->user_money = $userInfo->user_money - $rechargeOrder->recharge_price;
                            $userInfo->save();
                        } else {
                            $cardInfo = ElectricCard::where("card_id", $rechargeOrder->recharge_str)->first();
                            $cardInfo->money = $cardInfo->money - $rechargeOrder->recharge_price;
                            $cardInfo->save();
                        }
                    }, 5);
                    event(new SendWulian($event->devid, $answer));
                    if ($rechargeOrder->type == Charge::ORDER_RECHARGE_TYPE_USER) {
                        $userInfo = User::where("openid", $rechargeOrder->recharge_str)->first();
                        dispatch(new SendTemplateMsg($rechargeOrder->recharge_str,
                            "tK-cDfIBNxHi1Iw539U0XM-LL5bH3vCUei_KgkZeZHI", [
                                "first" => "尊敬的用户，您的充电已经完成！",
                                "keyword1" => $rechargeOrder->created_at,
                                "keyword2" => $rechargeOrder->recharge_end_time,
                                "keyword3" => (strtotime($rechargeOrder->recharge_end_time) - strtotime($rechargeOrder->created_time)) . "秒",
                                "keyword4" => ($userInfo->user_money * 1.0 / 100.00) . "元",
                                "keyword5" => $rechargeOrder->chargingEquipment->province . $rechargeOrder->chargingEquipment->city . $rechargeOrder->chargingEquipment->area . $rechargeOrder->chargingEquipment->street,
                                "remark" => "我们期待与您的下一次邂逅！",
                            ]));//充电结束
                    }
                    dispatch(new CalculateIncome($rechargeOrder->order_id));
                } catch (\Exception $e) {
                    $errmsg = [
                        "adr" => __METHOD__ . "," . __FUNCTION__,
                        "desc" => "下位机请求关闭订单，服务器处理失败！！！",
                        "detail" => serialize($event),
                    ];
                    Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
                }
            }
        }
    }

    /**
     * 功率
     */
    public function power($event)
    {
        $rechargeOrder = RechargeOrder::where("order_id", $event->order)->first();
        if (empty($rechargeOrder)) {
            return;
        }
        $rechargeOrder->power = $event->power;
        $res = $rechargeOrder->save();
        if ($res) {
            $answer = [
                "func" => "power",
                "ret" => "ok",
                "order" => $event->order,
            ];
            event(new SendWulian($event->devid, $answer));
        } else {
            Log::info(__FUNCTION__ . "-event:" . serialize($event));
        }
    }

    /**
     * 打开某插座
     */
    public function open($event)
    {
        DB::beginTransaction();
        try {
            $rechargeOrder = RechargeOrder::where("order_id", $event->order)->lockForUpdate()->first();
            if (empty($rechargeOrder)) {
                return;
            }
            if ($event->ret == "failed") {
                $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_FAILED;
                $rechargeOrder->save();
                $portInfo = EquipmentPort::where("equipment_id", $rechargeOrder->equipment_id)->where("port",
                    $rechargeOrder->port)->first();
                $portInfo->status = 0;
                $portInfo->save();
            } else {
                $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_CHARGING;
                $rechargeOrder->save();
                $portInfo = EquipmentPort::where("equipment_id", $rechargeOrder->equipment_id)->where("port",
                    $rechargeOrder->port)->first();
                $portInfo->status = Eletric::PORT_STATUS_USE;
                $portInfo->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();//事务回滚
            $errmsg = [
                "adr" => __METHOD__ . "," . __FUNCTION__,
                "desc" => "下位机开插座成功，但服务器订单开启失败！！！",
                "detail" => serialize($event),
            ];
            Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
        }
    }

    /**
     * 关闭某订单
     */
    public function cancel($event)
    {
        $rechargeOrder = RechargeOrder::where("order_id", $event->order)->first();
        if ($event->ret == "ok" && !empty($rechargeOrder)) {
            if ($rechargeOrder->recharge_status == Charge::ORDER_RECHARGE_STATUS_ENDING) {
                $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_END;
                $res = $rechargeOrder->save();
                if (!$res) {
                    Log::info(__FUNCTION__ . "-event:" . serialize($event));
                    $errmsg = [
                        "adr" => __METHOD__ . "," . __FUNCTION__,
                        "desc" => "下位机关闭订单成功，但服务器订单关闭失败！！！",
                        "detail" => serialize($event),
                    ];
                    Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
                }
            }
        }
    }

    public function changeNet($event)
    {
        $deviceInfo = ChargingEquipment::where("equipment_id", $event->devid)->first();
        if($deviceInfo["net_status"]==0 && $event->netStatus !="online") {
            return;
        }
        if($deviceInfo["net_status"]==1 && $event->netStatus == "online") {
            return;
        }

        if (!empty($deviceInfo)) {
            $deviceInfo["net_status"] = $event->netStatus == "online" ? 0 : "1";
            $res = $deviceInfo->save();
            if (!$res) {
                $errmsg = [
                    "adr" => __METHOD__ . "," . __FUNCTION__,
                    "desc" => "更改网络状态失败！！！",
                    "detail" => serialize($event),
                ];
                Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
            } else {
                dispatch(new SendTemplateMsg($deviceInfo->openid, "0dY3EdM8mmLMbJHIgWma0ZHQn8a7xzD1aJHN4obuK8M", [
                    "first" => Common::getPrexZero($event->devid),
                    "keyword1" => $event->netStatus == "online" ? "上线" : "断线",
                    "keyword2" => date("Y年m月d日 H:i"),
                    "remark" => $deviceInfo->province . $deviceInfo->city . $deviceInfo->area . $deviceInfo->street . $deviceInfo->address,
                ]));//网络更改
            }
        }
    }

    public function ota($event)
    {
        if($event->version != Eletric::DEVICE_VERSION || $event->size+$event->offset >  Eletric::DEVICE_VERSION_SIZE) {
            $answer = [
                "func" => "ota",
                "ret" => "failed",
            ];
            event(new SendWulian($event->devid, $answer));
        }else{
            $answer = [
                "func" => "ota",
                "ret" => "ok",
                "offset" => $event->offset,
                "size" => $event->size,
                "data" => substr(Eletric::DEVICE_VERSION_BIN, $event->offset, $event->size),
                "version" => (integer)(Eletric::DEVICE_VERSION),
            ];
            event(new SendWulian($event->devid, $answer));
        }
    }

    /**
     * 为订阅者注册监听器.
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Msns\register',
            'App\Listeners\MsnEventSubscriber@register'//注册
        );

        $events->listen(
            'App\Events\Msns\sync',
            'App\Listeners\MsnEventSubscriber@sync'//同步订单
        );

        $events->listen(
            'App\Events\Msns\card_request',
            'App\Listeners\MsnEventSubscriber@card_request'//电卡刷卡
        );

        $events->listen(
            'App\Events\Msns\card_charge',
            'App\Listeners\MsnEventSubscriber@card_charge'//电卡充电回复
        );

        $events->listen(
            'App\Events\Msns\charge_finish',
            'App\Listeners\MsnEventSubscriber@charge_finish'//充电结束（电卡和用户）
        );

        $events->listen(
            'App\Events\Msns\power',
            'App\Listeners\MsnEventSubscriber@power'//功率
        );

        $events->listen(
            'App\Events\Msns\open',
            'App\Listeners\MsnEventSubscriber@open'//扫码充电回复
        );

        $events->listen(
            'App\Events\Msns\cancel',
            'App\Listeners\MsnEventSubscriber@cancel'//结束充电回复
        );

        $events->listen(
            'App\Events\Msns\changeNet',
            'App\Listeners\MsnEventSubscriber@changeNet'//网络状态
        );

        $events->listen(
            'App\Events\Msns\ota',
            'App\Listeners\MsnEventSubscriber@ota'//升级
        );
    }
}