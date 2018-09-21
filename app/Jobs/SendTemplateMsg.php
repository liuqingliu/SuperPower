<?php

namespace App\Jobs;

use App\Models\Logic\Common;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mockery\Exception;

use Illuminate\Support\Facades\Log;

class SendTemplateMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $message = [];

    public $openid;

    public $templateId;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($openid, $templateId, $message)
    {
        $this->message = $message;
        $this->openid = $openid;
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
            Log::info("send_template_msg_start:".json_encode($this->message).",".$this->openid.",".$this->templateId);
            $app = app('wechat.official_account');
            $userInfo = User::where("openid",$this->openid)
                ->where("user_status", Common::USER_STATUS_DEFAULT)
                ->whereIn("user_type", Common::$dealers)
                ->first();//防止离职或者禁用也去给他们发消息
            Log::info("222:".json_encode($userInfo));
            if(empty($userInfo)){
                return;
            }
            $app->template_message->send([
                'touser' => $this->openid,
                'template_id' => $this->templateId,
                'url' => '',
                'data' => $this->message,
            ]);
            echo "ok！";
        } catch (\Exception $exception) {
            Log::info("send_template_msg_error:" . $exception->getMessage());
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
        Log::info("fail_send_template:" . serialize($exception->getMessage()));
    }
}
