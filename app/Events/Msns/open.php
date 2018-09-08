<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:02
 */


namespace App\Events\Msns;

use Illuminate\Queue\SerializesModels;
//“ret”:”…”,
// “order”:”16字符”


class open
{
    use SerializesModels;

    public $ret;

    public $order;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($message)
    {
        $this->ret =   $message["ret"];
        $this->order = $message["order"];
    }
}