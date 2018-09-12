<?php

namespace App\Jobs;

use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\RechargeOrder;
use DefaultAcsClient;
use DefaultProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

use Illuminate\Support\Facades\Log;
use \Iot\Request\V20170420 as Iot;

class SendWulianQue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $message;

    public $devid;

    public $times;
    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($devid, $message, $times = 0)
    {
        $this->message = $message;
        $this->devid = $devid;
        $this->times = $times;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try{
            Log::info("send_wulian_que_start:");
            $accessKeyId = env("QUEUE_MNS_ACCESS_KEY_LIUQING");
            $accessSecret = env("QUEUE_MNS_SECRET_KEY_LIUQING");
            $func = $this->message["func"];
            if ($func == "card_charge" || $func == "open") {
                //查询是否开始计费了，就不需要重发了
                $rechargeOrder = RechargeOrder::where("order_id",$this->message["order"])->first();
                if (empty($rechargeOrder) || $rechargeOrder->recharge_status != Charge::ORDER_RECHARGE_STATUS_DEFAULT) {
                    return;
                }
            }
            if ($func == "cancel") {
                //查询是否开始计费了，就不需要重发了
                $rechargeOrder = RechargeOrder::where("order_id",$this->message["order"])->first();
                if ($rechargeOrder->recharge_status == Charge::ORDER_RECHARGE_STATUS_END) {
                    return;
                }
            }
//        DefaultProfile::addEndpoint("cn-shanghai","cn-shanghai","Iot","iot.cn-shanghai.aliyuncs.com");
            $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
            $client = new DefaultAcsClient($iClientProfile);
            $request = new Iot\PubRequest();
            $request->setProductKey("a1GBdrPMPst");
            $request->setMessageContent(base64_encode(json_encode($this->message))); //Base64 String.
            $devid = $this->devid;
            $request->setTopicFullName("/a1GBdrPMPst/{$devid}/serverData"); //消息发送到的Topic全名.
            $response = $client->getAcsResponse($request);
            Log::info("send_wulian_res:" . serialize($response) . ",message:" . json_encode($this->message));
            if($this->times>=2){
                return;
            }

            sleep(5);
            dispatch(new SendWulianQue($this->devid, $this->message, $this->times+1));//下发3次，直到有回复过来

        }catch (\Exception $exception){
            Log::error("send_wulian_que_error:".$exception->getMessage());
        }

    }

    /**
     * 要处理的失败任务。
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        Log::info("fail_send_wulian:".serialize($exception->getMessage()));
    }
}
