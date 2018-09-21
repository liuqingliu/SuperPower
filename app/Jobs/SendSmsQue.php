<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/31
 * Time: 22:13
 */
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Toplan\PhpSms\Sms;
use SmsManager;
use PhpSms;

class SendSmsQue extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Sms $sms
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     *
     * @return void
     */
    public function handle()
    {
        $sms = PhpSms::make("Aliyun","SMS_143560259")->to("15701160070")->data(["code" => "5522"]);
        var_dump($sms);
        $res = $sms->send();
        Log::info("res:".serialize($res));
    }

    /**
     * 要处理的失败任务。
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        // 给用户发送失败通知，等等...
        Log::info("fail_send_sms11:".serialize($exception->getMessage()));
    }
}
