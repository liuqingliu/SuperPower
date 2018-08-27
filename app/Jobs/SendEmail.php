<?php

namespace App\Jobs;

use App\Mail\WechatOrder;
use App\Models\Logic\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $msg;

    public function __construct($msg)
    {
        //
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::raw("ces",function ($message){
            // 收件人的邮箱地址
            $message->to(['609163616@qq.com']);
            // 邮件主题
            $message->subject('队列发送邮件');
        })->view('emails.wechat.order')
            ->with([
                'msg' => $this->msg,
            ]);
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
        var_dump($exception->getMessage());
    }
}
