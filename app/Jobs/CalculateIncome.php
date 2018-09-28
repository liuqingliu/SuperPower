<?php

namespace App\Jobs;

use App\Mail\CommonError;
use App\Models\Dealer;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
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
                        Charge::ORDER_RECHARGE_FLAG_DEFAULT)->where("recharge_status",
                        Charge::ORDER_RECHARGE_STATUS_END)->lockForUpdate()->first();
                    if (empty($rechargeOrder)) {
                        throw new \Exception("充电订单不存在:order_id=".$orderId);
                        return;
                    }
                    $rechargeOrder->in_come_flag = Charge::ORDER_RECHARGE_FLAG_IN_COMED;
                    $rechargeOrder->save();
                    $deviceInfo = $rechargeOrder->chargingEquipment;
                    $dealerInfo = Dealer::where("openid", $deviceInfo->openid)->first();
                    $dealerInfo->total_income = $dealerInfo->total_income + $rechargeOrder->recharge_price *
                        (100 - $dealerInfo->give_proportion) * 0.01;
                    $deviceInfo->save();
                    $dealerInfoSuper = Dealer::where("openid", $dealerInfo->parent_openid)->first();
                    if (!empty($dealerInfoSuper)) {
                        $dealerInfoSuper->total_income = $dealerInfoSuper->total_income + $rechargeOrder->recharge_price *
                            $dealerInfoSuper->give_proportion * 0.01 * (100 - $dealerInfo->give_proportion) * 0.01;
                        $dealerInfoSuper->save();
                        $cs = Dealer::where("openid", $dealerInfoSuper->parent_openid)->first();
                        if (!empty($cs)) {
                            $cs->total_income = $cs->total_income + $rechargeOrder->recharge_price *
                                $dealerInfoSuper->give_proportion * 0.01 * $dealerInfo->give_proportion * 0.01;
                            $cs->save();
                        }
                    }
                }, 5);
            } catch (\Exception $e) {
                Log::debug("auto_close_error1:" . serialize($e->getMessage()));
                return;
            }
        } catch (\Exception $exception) {
            Log::info("calculate_income_error:" . $exception->getMessage());
            $errmsg = [
                "adr" => __METHOD__ . "," . __FUNCTION__,
                "desc" => "计算收入有误",
                "detail" => "order_id=" . $this->orderId,
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
        Log::info("fail_calculate_income:" . serialize($exception->getMessage()));
        $errmsg = [
            "adr" => __METHOD__ . "," . __FUNCTION__,
            "desc" => "计算收入有误",
            "detail" => "order_id=" . $this->orderId,
        ];
        Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
    }
}