<?php

namespace App\Jobs;

use App\Models\ChargingEquipment;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Eletric;
use App\Models\RechargeOrder;
use App\Models\User;
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

class SendTemplateMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $message;

    public $devid;

    public $templateId;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($devid, $templateId, $message)
    {
        $this->message = $message;
        $this->devid = $devid;
        $this->templateId = $templateId;
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
            Log::info("send_template_msg_start:");
            $app = app('wechat.official_account');
            $deviceInfo = ChargingEquipment::where("equipment_id", $this->devid)->first();
            if (empty($deviceInfo) || $deviceInfo["equipment_status"] == Eletric::DEVICE_STATUS_ERROR) {
                return;
            }
            $userInfo = User::where("openid",$deviceInfo->openid)
                ->where("user_status", Common::USER_STATUS_DEFAULT)
                ->whereIn("user_type", Common::$dealers)
                ->first();//防止离职或者禁用也去给他们发消息
            if(empty($userInfo)){
                return;
            }
            $app->template_message->send([
                'touser' => $deviceInfo->openid,
                'template_id' => $this->templateId,
                'url' => 'https://easywechat.org',
                'data' => $this->message,
            ]);
            echo "ok！";
        } catch (\Exception $exception) {
            Log::error("send_template_msg_error:" . $exception->getMessage());
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
        Log::info("fail_send_wulian:" . serialize($exception->getMessage()));
    }

}
