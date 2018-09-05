<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:04
 */

namespace App\Listeners;

use App\Events\ReceiveMsn;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MsndealListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \App\Events\ReceiveMsn $event
     * @return void
     */
    public function handle(ReceiveMsn $event)
    {
        switch ($event->message["func"]) {
            case "register" :
                break;//上报信息
            case "sync" :
                break;//同步订单
            case "card_request" :
                break;//电卡刷卡
            case "card_charge" :
                break;//电卡充电请，开始计费
            case "charge_finish":
                break;//充电结束
            case "power" :
                break;//功率
            case "open" :
                break;//打开某插座
            case "cancel" :
                break;//关闭某订单
        }
    }

    /**
     * 处理任务失败
     *
     * @param  \App\Events\OrderShipped $event
     * @param  \Exception $exception
     * @return void
     */
    public function failed(ReceiveMsn $event, $exception)
    {
        //
        Log::alert("fail_deal_msn:" . serialize($event) . ",exception-msg:" . $exception->getMessage());
    }
}