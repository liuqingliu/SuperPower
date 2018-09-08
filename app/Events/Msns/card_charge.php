<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:02
 */


namespace App\Events\Msns;

use Illuminate\Queue\SerializesModels;
//{
//
//“ret”:”…”,
// “cardId”:” 11字符”，
//}
//feng哥懒得不想改名，导致代码风格不统一
class card_charge
{
    use SerializesModels;

    public $cardId;

    public $ret;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($message)
    {
        $this->cardId = $message["cardId"];
        $this->ret = $message["ret"];
    }
}