<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:02
 */


namespace App\Events\Msns;

use Illuminate\Queue\SerializesModels;
//“devid”:”15字符”，
//	“order”	:”16字符”
//	“power”:整型数据，单位瓦特(订单字段)

class power
{
    use SerializesModels;

    public $devid;

    public $order;

    public $power;

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
        $this->power = $message["power"];
    }
}