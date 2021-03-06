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

class SendSms extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sms;

    /**
     * Create a new job instance.
     *
     * @param Sms $sms
     */
    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        PhpSms::make();//！！！！！恶心！！！！不知道为什么非要加一个这句话！！！！why？？？？tell me why？？？困扰2天了！！日
        $this->sms->send();
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
        Log::info("fail_send_sms:".serialize($exception->getMessage()));
    }
}
