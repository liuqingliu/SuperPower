<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:02
 */


namespace App\Events\Msns;

use Illuminate\Queue\SerializesModels;
//feng哥懒得不想改名，导致代码风格不统一
class charge_finish
{
    use SerializesModels;

    public $order;

    public $devid;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($message)
    {
        $this->devid = $message["devid"];
        $this->order = $message["order"];
    }
}