<?php

namespace App\Jobs;

use App\Mail\CommonError;
use App\Models\CashLog;
use App\Models\Dealer;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Snowflake;
use App\Models\RechargeOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

use Illuminate\Support\Facades\Log;

class CalculateIncome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $orderId;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try {
            Log::info("calculate_income_start:order_id=" . $this->orderId);
            //订单分在经销商价钱
            $orderId = $this->orderId;
            try {
                DB::transaction(function () use ($orderId) {
                    $rechargeOrder = RechargeOrder::where("order_id", $orderId)->where("in_come_flag",
                        Charge::ORDER_RECHARGE_FLAG_DEFAULT)->whereIn("recharge_status",
                        [
                            Charge::ORDER_RECHARGE_STATUS_END,
                            Charge::ORDER_RECHARGE_STATUS_ENDING
                        ])->lockForUpdate()->first();
                    if (empty($rechargeOrder)) {
                        DB::rollback();
                        throw new \Exception("充电订单不存在:order_id=" . $orderId);
                        return;
                    }
                    $rechargeOrder->in_come_flag = Charge::ORDER_RECHARGE_FLAG_IN_COMED;
                    $rechargeOrder->save();
                    $deviceInfo = $rechargeOrder->chargingEquipment;
                    $dealerInfo = Dealer::where("openid", $deviceInfo->openid)->first();
                    if (empty($dealerInfo)) {
                        DB::rollback();
                        throw new \Exception("经销商不存在:openid=" . $deviceInfo->openid);
                        return;
                    }
                    if($dealerInfo->user->user_type == Common::USER_TYPE_ADMIN) {
                        $addPrice = $rechargeOrder->recharge_price;
                    }else {
                        $addPrice = Common::getInt(floor($rechargeOrder->recharge_price * (100 - $dealerInfo->give_proportion) * 0.01));
                    }
                    if ($addPrice == 0) {
                        return;
                    }
                    $dealerInfo->total_income = $dealerInfo->total_income + $addPrice;
                    $dealerInfo->save();
                    CashLog::create([
                        "openid" => $deviceInfo->openid,
                        "equipment_id" => $deviceInfo->equipment_id,
                        "cash_id" => Snowflake::nextId(),
                        "cash_type" => Common::CASH_TYPE_DEVIC,
                        "cash_status" => Common::CASH_STATUS_INCOME,
                        "cash_price" => $addPrice,
                    ]);
                    if($dealerInfo->user->user_type == Common::USER_TYPE_ADMIN) {
                        return;
                    }
                    $dealerInfoSuper = Dealer::where("openid", $dealerInfo->parent_openid)->first();
                    if (!empty($dealerInfoSuper)) {
                        if($dealerInfoSuper->user->user_type == Common::USER_TYPE_ADMIN) {
                            $spAddPrice = $rechargeOrder->recharge_price - $addPrice;
                        }else {
                            $spAddPrice = Common::getInt(floor($rechargeOrder->recharge_price * ($dealerInfo->give_proportion - $dealerInfoSuper->give_proportion) * 0.01));
                        }

                        if ($spAddPrice == 0) {
                            return;
                        }
                        $dealerInfoSuper->total_income = $dealerInfoSuper->total_income + $spAddPrice;
                        $dealerInfoSuper->save();
                        CashLog::create([
                            "openid" => $dealerInfoSuper->openid,
                            "equipment_id" => $deviceInfo->equipment_id,
                            "cash_id" => Snowflake::nextId(),
                            "cash_type" => Common::CASH_TYPE_SHARE,
                            "cash_status" => Common::CASH_STATUS_INCOME,
                            "cash_price" => $spAddPrice,
                        ]);
                        if($dealerInfoSuper->user->user_type == Common::USER_TYPE_ADMIN) {
                            return;
                        }
                        $cs = Dealer::where("openid", $dealerInfoSuper->parent_openid)->first();
                        if (!empty($cs)) {
                            $csAddPrice = $rechargeOrder->recharge_price - $addPrice - $spAddPrice;
                            if ($csAddPrice == 0) {
                                return;
                            }
                            $cs->total_income = $cs->total_income + $csAddPrice;
                            $cs->save();
                            CashLog::create([
                                "openid" => $cs->openid,
                                "equipment_id" => $deviceInfo->equipment_id,
                                "cash_id" => Snowflake::nextId(),
                                "cash_type" => Common::CASH_TYPE_SHARE,
                                "cash_status" => Common::CASH_STATUS_INCOME,
                                "cash_price" => $csAddPrice,
                            ]);
                        }
                    }
                });
            } catch (\Exception $e) {
                Log::debug("calculate_income:" . serialize($e->getMessage()));
                return;
            }
        } catch (\Exception $exception) {
            $errmsg = [
                "adr" => __METHOD__ . "," . __FUNCTION__,
                "desc" => "计算收入有误",
                "detail" => "order_id=" . $this->orderId ."exception:".$exception->getMessage(),
            ];
            Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
        }

    }

    /**
     * 要处理的失败任务。
     *
     * @param  Exception $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        $errmsg = [
            "adr" => __METHOD__ . "," . __FUNCTION__,
            "desc" => "计算收入有误",
            "detail" => "order_id=" . $this->orderId ."exception:".$exception->getMessage(),
        ];
        Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
    }
}
