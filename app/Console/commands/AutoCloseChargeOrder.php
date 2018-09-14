<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/4
 * Time: 17:45
 */

namespace App\Console\Commands;

use App\Mail\CommonError;
use App\Models\ElectricCard;
use App\Models\EquipmentPort;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Eletric;
use App\Models\RechargeOrder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AutoCloseChargeOrder extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'AutoCloseChargeOrder:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动关闭订单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * 1.订单状态置为已完结。
     * - 2.数据库中插座占用状态置为可用。
     * - 3.从用户账户扣款（即改写数据库值）
     * - 4.根据既定分成规则，打款到所有相关经销商账户余额。
     * - 5.生成各个相关经销商打款流水单并存储。
     * - 6.微信推送相关信息。
     *
     * @return mixed
     */
    //todo 4,5
    public function handle()
    {
        $rechargeOrderList = RechargeOrder::whereIn("recharge_status",
            [Charge::ORDER_RECHARGE_STATUS_DEFAULT, Charge::ORDER_RECHARGE_STATUS_CHARGING])
            ->where("created_at", ">", date("Y-m-d", strtotime("-12 hours")))
            ->get();
        //1.超时未关闭
        // a. 还未开始，关闭
        // b. 计费未结束

        foreach ($rechargeOrderList as $rechargeOrder) {
            Log::info("fuck_order:".serialize($rechargeOrder));
            if ($rechargeOrder->recharge_status == Charge::ORDER_RECHARGE_STATUS_DEFAULT) {
                if (time() - strtotime($rechargeOrder->created_at) >= 5 * Common::ONE_MINUTE_SECONDES) {
                    try {
                        DB::transaction(function () use ($rechargeOrder) {
                            $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_ORVERTIME;
                            $rechargeOrder->save();
                            $portInfo = EquipmentPort::where("equipment_id",
                                $rechargeOrder->equipment_id)->where("port",
                                $rechargeOrder->port)->first();
                            $portInfo->status = Eletric::PORT_STATUS_DEFAULT;
                            $portInfo->save();
                        }, 5);
                    } catch (\Exception $e) {
                        Log::debug("auto_close_error1:" . serialize($e->getMessage()));
                        return;
                    }
                }
            }
            if ($rechargeOrder->recharge_status == Charge::ORDER_RECHARGE_STATUS_CHARGING) {
                if (time() > strtotime($rechargeOrder->created_at) + $rechargeOrder->recharge_total_time) {
                    try {
                        DB::transaction(function () use ($rechargeOrder) {
                            $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_END;
                            $rechargeOrder->recharge_end_time = date("Y-m-d H:i:s");
                            $rechargeOrder->recharge_price = $rechargeOrder->recharge_unit_money * $rechargeOrder->recharge_total_time;
                            $rechargeOrder->save();
                            $portInfo = EquipmentPort::where("equipment_id",
                                $rechargeOrder->equipment_id)->where("port",
                                $rechargeOrder->port)->first();
                            $portInfo->status = Eletric::PORT_STATUS_DEFAULT;
                            Log::info("port_info_auto_close:".serialize($portInfo));
                            $portInfo->save();
                            if ($rechargeOrder->type == Charge::ORDER_RECHARGE_TYPE_USER) {
                                $userInfo = User::where("openid", $rechargeOrder->recharge_str)->first();
                                Log::info("user_info_auto_close:".serialize($userInfo));
                                $userInfo->user_money = $userInfo->user_money - $rechargeOrder->recharge_price;
                                $userInfo->save();
                            } else {
                                $cardInfo = ElectricCard::where("card_id", $rechargeOrder->recharge_str)->first();
                                $cardInfo->money = $cardInfo->money - $rechargeOrder->recharge_price;
                                $cardInfo->save();
                            }
                        }, 5);
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
                    } catch (\Exception $e) {
                        Log::debug("auto_close_error2:" . serialize($e->getMessage()));
                        $errmsg = [
                            "adr" => __METHOD__.",".__FUNCTION__,
                            "desc" => "自动关闭订单失败",
                            "detail" => $e->getMessage(),
                        ];
                        Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
                    }
                }
            }
        }
    }

}
