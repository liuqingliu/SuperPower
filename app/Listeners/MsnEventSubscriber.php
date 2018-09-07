<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/6
 * Time: 11:21
 */

namespace App\Listeners;


use App\Events\SendWulian;
use App\Models\ChargingEquipment;
use App\Models\ElectricCard;
use App\Models\EquipmentPort;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Eletric;
use App\Models\Logic\Snowflake;
use App\Models\RechargeOrder;
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
            Eletric::DEVICE_STATUS_STATUS)->where("net_status", Eletric::DEVICE_NET_STATUS)->first();
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
        event(new SendWulian($event->devid, $answer));
        //如果有设备三块板子都有问题，则报警
        if ($event->board1 == "N" && $event->board2 == "N" && $event->board3 == "N") {
            Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new WechatOrder("有设备三个板子都坏了！！！设备编号：" . $event->devid));
        }
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
            "data" => [],
        ];
        //订单号16B+端口号2B(不足2B补齐)+可用时间5B ==23B
        //如20180829000000010110010,表示订单2018082900000001在1号端口，可以时间10010秒。
        //如果以后订单超过16b限制，则这里也需要修改，慎重！！
        foreach ($orderList as $order) {
            $tmp = $order->order_id . Common::getPrexZero($order->port,
                    2) . Common::getPrexZero(($order->recharge_total_time - $order->recharge_time), 5);
            Log::info("tmp:" . $tmp . ",port:" . Common::getPrexZero($order->port,
                    2) . ",time:" . Common::getPrexZero(($order->recharge_total_time - $order->recharge_time),
                    5) . ",total_time:" . $order->recharge_total_time . ",recharge_time:" . $order->recharge_time);
            $answer["data"][] = $tmp;
        }
        event(new SendWulian($event->devid, $answer));
    }

    /**
     * 电卡刷卡，下位机请求三次
     */
    public function card_request($event)
    {
        //如果有端口没加进来
        $deviceInfo = ChargingEquipment::where("equipment_id", $event->devid)->first();
        if (!empty($deviceInfo) || empty($deviceInfo->equipmentports)) {
            Log::info("card_request:" . serialize($event));
            return;
        }
        $cardInfo = ElectricCard::where("card_id", $event->cardId)->first();
        $answer = [
            "func" => " card_charge",
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
        }

        if ($cardInfo->money < 200) {//小于2元
            $answer["cause"] = "insuffic";
            $answer["cmd"] = "refuse";
        }
        //查询当前设备和port
        $portInfo = EquipmentPort::where("equipment_id", $event->devid)->where("port", $event->port)->first();
        if ($portInfo->status == Eletric::PORT_STATUS_USE) {
            $answer["cause"] = "porterr";
            $answer["cmd"] = "refuse";
        }
        if ($answer["cmd"] == "open") {
            //创建订单,设置port为不可用
            $orderInfo = [
                "order_id" => Snowflake::nextId(),
                "recharge_str" => $event->cardId,
                "equipment_id" => $event->devid,
                "port" => $event->port,
                "recharge_unit_money" => $deviceInfo->charging_unit_price,
                "type" => Charge::ORDER_RECHARGE_TYPE_CARD,
            ];
            $answer["left_time"] = 8 * Common::ONE_HOUR_SECONDES;
            try {
                DB::transaction(function () use ($event, $orderInfo, $portInfo) {
                    RechargeOrder::insert($orderInfo);
                    $portInfo->status = Eletric::PORT_STATUS_USE;
                    $portInfo->save();
                }, 5);
            } catch (\Exception $e) {
                Log::debug("msn_recharge_insert_error:" . serialize($e->getMessage()));
                return;
            }
        }
        $answer["order"] = $orderInfo["order_id"];
        $answer["cash"] = $cardInfo->money;

        $cnt = 0;
        while ($cnt <= 10) {
            if ($cnt % 5 == 0) {
                event(new SendWulian($event->devid, $answer));//下发3次，直到有回复过来
            }
        }
    }

    /**
     * 电卡充电请，开始计费
     */
    public function card_charge($event)
    {
        $answer = [
            "func" => "card_charge",
            "order" => "",
            "cmd" => "open",// open或refuse
            "port" => $event->port,
            "cause" => "", //block,未激活(不存在)； insuffic,余额不足，porterr,端口不可用
            "cash" => 0,
            "left_time" => 0
        ];
        if ($event->ret == "ok") {
            $rechargeOrder = RechargeOrder::where("recharge_str", $event->cardId)->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_DEFAULT)->first();
            if (!empty($rechargeOrder)) {
                $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_CHARGING;
                $res = $rechargeOrder->save();
                if(!$res){
                    Log::info(__FUNCTION__."-event:".serialize($event));
                }
            }
        }
    }

    /**
     * 充电结束
     */
    public function charge_finish($event)
    {
        $rechargeOrder = RechargeOrder::where("order_id",$event->order)->first();
        if(!empty($rechargeOrder)){
            if($rechargeOrder->recharge_status!=Charge::ORDER_RECHARGE_STATUS_END){
                $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_END;
                $res = $rechargeOrder->save();
                if(!$res){
                    Log::info(__FUNCTION__."-event:".serialize($event));
                    Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new WechatOrder("下位机关闭订单处理失败！！！"));
                }

            }
        }
    }

    /**
     * 功率
     */
    public function power($event)
    {
    }

    /**
     * 打开某插座
     */
    public function open($event)
    {
    }

    /**
     * 关闭某订单
     */
    public function cancel($event)
    {
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
            'App\Listeners\MsnEventSubscriber@register'
        );

        $events->listen(
            'App\Events\Msns\sync',
            'App\Listeners\MsnEventSubscriber@sync'
        );

        $events->listen(
            'App\Events\Msns\card_request',
            'App\Listeners\MsnEventSubscriber@card_request'
        );

        $events->listen(
            'App\Events\Msns\card_charge',
            'App\Listeners\MsnEventSubscriber@card_charge'
        );

        $events->listen(
            'App\Events\Msns\charge_finish',
            'App\Listeners\MsnEventSubscriber@charge_finish'
        );

        $events->listen(
            'App\Events\Msns\power',
            'App\Listeners\MsnEventSubscriber@power'
        );

        $events->listen(
            'App\Events\Msns\open',
            'App\Listeners\MsnEventSubscriber@open'
        );

        $events->listen(
            'App\Events\Msns\cancel',
            'App\Listeners\MsnEventSubscriber@cancel'
        );
    }
}