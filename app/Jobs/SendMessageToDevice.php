<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/31
 * Time: 22:13
 */
namespace App\Jobs;

use App\Mail\CommonError;
use App\Models\Logic\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use \Iot\Request\V20170420 as Iot;

class SendMessageToDevice extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     *
     * @param Sms $sms
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $accessKeyId = env("QUEUE_MNS_ACCESS_KEY_LIUQING");
            $accessSecret = env("QUEUE_MNS_SECRET_KEY_LIUQING");
//        DefaultProfile::addEndpoint("cn-shanghai","cn-shanghai","Iot","iot.cn-shanghai.aliyuncs.com");
            $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
            $client = new DefaultAcsClient($iClientProfile);
            $request = new Iot\PubRequest();
            $request->setProductKey("a1GBdrPMPst");
            $request->setMessageContent($this->message); //hello world Base64 String.
            $request->setTopicFullName("/a1GBdrPMPst/869300034342472/serverData"); //消息发送到的Topic全名.
            $response = $client->getAcsResponse($request);
            if ($response->Success != Common::STATUS_SEND_SUCCESS) {
                $errmsg = [
                    "adr" => __METHOD__.",".__FUNCTION__,
                    "desc" => "给下位机发消息失败",
                    "detail" => serialize($response),
                ];
                Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
            }
            Log::info("call_device_info:".serialize($response));
        }catch (\Exception $e){
            $errmsg = [
                "adr" => __METHOD__.",".__FUNCTION__,
                "desc" => "给下位机发消息异常",
                "detail" => serialize($response),
            ];
            Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
        }
    }
}
