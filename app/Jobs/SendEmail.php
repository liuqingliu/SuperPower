<?php

namespace App\Jobs;

use App\Models\Logic\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mailType;

    protected $emailUser = ["609163616@qq.com"];

    protected $content;


    public function __construct($mailType, $content)
    {
        //
        $this->mailType = $mailType;
        $this->content = $content;
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
            $mailTypeClass = 'App\Mail\\'.$this->mailType;
            echo $mailTypeClass."\n";
            Mail::to($this->emailUser)->send(new $mailTypeClass($this->content));
            echo "ok\n";
        }catch (\Exception $exception){
            Log::info("sendmail_error:".$exception->getMessage());
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
        // 给用户发送失败通知，等等...
        Log::info("fail_send_email:".serialize($exception->getMessage()));
    }
}
