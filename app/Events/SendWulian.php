<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/6
 * Time: 14:20
 */
namespace App\Events;

use Illuminate\Queue\SerializesModels;

class SendWulian
{
    use SerializesModels;

    public $message;

    public $devid;
    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($devid, $message)
    {
        $this->message = $message;
        $this->devid = $devid;
    }
}