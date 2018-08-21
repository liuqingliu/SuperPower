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
    public static $errSys = ["errno"=>"3","errmsg"=>"系统错误"];
    public static $errNotSelfUser = ["errno" => 4, "errmsg" => "不是用户本人"];
    public static $errChargingStatus = ["errno" => 5, "errmsg" => "充电订单状态有误"];
    public static $errNet = ["errno" => 6, "errmsg" => "网络错误"];
}