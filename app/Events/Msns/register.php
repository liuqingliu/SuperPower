<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:02
 */


namespace App\Events\Msns;

use Illuminate\Queue\SerializesModels;

class register
{
    use SerializesModels;

    public $devid;

    public $board1;

    public $board2;

    public $board3;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($message)
    {
        $this->devid = $message["devid"];
        $this->board1 = $message["board1"];
        $this->board2 = $message["board2"];
        $this->board3 = $message["board3"];
    }
}