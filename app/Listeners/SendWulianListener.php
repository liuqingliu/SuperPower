<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:04
 */

namespace App\Listeners;

use App\Events\SendWulian;
use App\Models\Logic\Charge;
use App\Models\RechargeOrder;
use DefaultAcsClient;
use DefaultProfile;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Log;
use \Iot\Request\V20170420 as Iot;

//给下位机发消息应该是实时的，并非使用队列
class SendWulianListener
{
//    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \App\Events\ReceiveMsn $event
     * @return void
     */
    public function handle(SendWulian $event)
    {
        Log::info("send_wulian:" . serialize($event) );
        $accessKeyId = env("QUEUE_MNS_ACCESS_KEY_LIUQING");
        $accessSecret = env("QUEUE_MNS_SECRET_KEY_LIUQING");
        $func = $event->message["func"];
        if ($func == "card_charge") {
            //查询是否开始计费了，就不需要重发了
            $rechargeOrder = RechargeOrder::where("order_id",$event->message["order"])->first();
            if ($rechargeOrder->recharge_status != Charge::ORDER_RECHARGE_STATUS_DEFAULT) {
                return;
            }
        }
//        DefaultProfile::addEndpoint("cn-shanghai","cn-shanghai","Iot","iot.cn-shanghai.aliyuncs.com");
        $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
        $client = new DefaultAcsClient($iClientProfile);
        $request = new Iot\PubRequest();
        $request->setProductKey("a1GBdrPMPst");
        $request->setMessageContent(base64_encode(json_encode($event->message))); //Base64 String.
        $devid = $event->devid;
        $request->setTopicFullName("/a1GBdrPMPst/{$devid}/serverData"); //消息发送到的Topic全名.
        $response = $client->getAcsResponse($request);
        Log::info("send_wulian_res:" . serialize($response) . ",message:" . json_encode($event->message));
    }

    /**
     * 处理任务失败
     *
     * @param  \App\Events\OrderShipped $event
     * @param  \Exception $exception
     * @return void
     */
    public function failed(SendWulian $event, $exception)
    {
        //
        Log::error("fail_send_wu_lian:" . serialize($event) . ",exception-msg:" . $exception->getMessage());
    }
}