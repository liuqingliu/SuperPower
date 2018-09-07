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
//	“card_id”:”11字符”,
//	“port”:整型数据
//feng哥懒得不想改名，导致代码风格不统一
class card_request
{
    use SerializesModels;

    public $devid;

    public $cardId;

    public $port;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($message)
    {
        $this->devid = $message["devid"];
        $this->cardId = $message["card_id"];
        $this->port = $message["port"];
    }
}