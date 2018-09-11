<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/11
 * Time: 10:00
 */

namespace App\Events\Msns;

use Illuminate\Queue\SerializesModels;

class changeNet
{
    use SerializesModels;

    public $devid;

    public $netStatus;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($devid, $netStatus)
    {
        $this->devid = $devid;
        $this->netStatus = $netStatus;
    }
}