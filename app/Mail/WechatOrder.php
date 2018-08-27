<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/27
 * Time: 17:26
 */
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class WechatOrder extends  Mailable
{
    use Queueable, SerializesModels;

    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('609163616@qq.com')
            ->view('emails.wechat.order')
            ->with([
                'msg' => $this->message,
            ]);
    }

}
