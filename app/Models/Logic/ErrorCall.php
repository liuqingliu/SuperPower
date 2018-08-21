<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/20
 * Time: 19:56
 */

namespace App\Models\Logic;

class ErrorCall
{
    public static $errSucc = ["errno" => "0", "errmsg" => "ok"];
    public static $errNotFoundInfo = ["errno" => "1", "errmsg" => "没发现信息"];
    public static $errParams = ["errno"=>"2","errmsg"=>"参数错误"];
}