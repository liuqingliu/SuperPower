<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/17
 * Time: 18:46
 */

namespace App\Models\Logic;

class Common
{
    //用户类型
    const USER_TYPE_NORMAL = 0;//普通
    const USER_TYPE_JXS = 1;//经销商
    const USER_TYPE_SJXS = 2;//超级经销商
    const USER_TYPE_ADMIN = 3;//厂商

    //用户状态
    const USER_STATUS_DEFAULT = 0;//默认正常
    const USER_STATUS_FREEZONE = 1;//冻结用户状态

    //充电订单状态
    const CHARGING_STATUS_DEFAULT = 0;//默认正在充电
    const CHARGING_STATUS_STOP = 1;//停止充电状态

    //电卡状态
    const ELETRIC_CARD_STATUS_DEFAULT = 0;//电卡默认状态
    const ELETRIC_CARD_STATUS_FREEZONE = 1;//电卡冻结状态

    //时间
    const ONE_WEEK_SECONDES = 7 * 24 * 3600;

    //session_key
    const SESSION_KEY_USER = "user_info";

    //iot状态
    const STATUS_SEND_SUCCESS = 1;

    //mail_exception_wechat_order
    public static $emailOferrorForWechcatOrder = [
        "609163616@qq.com"
    ];

    public static function getNeedArray($needArr, $org)
    {
        $res = [];
        foreach ($needArr as $value) {
            $res["{$value}"] = isset($org["{$value}"]) ? $org["{$value}"] : "";
        }
        return $res;
    }

    public static function getNeedObj($needObj, $org)
    {
        $res = $org;
        foreach ($org->toArray() as $key => $value) {
            if(!in_array($key, $needObj)) {
                unset($res->$key);
            }
        }
        return $res;
    }

    public static function getCost($unitPrice, $time)
    {
        return ($unitPrice * 0.01 * 1.0 / 60.0) * $time;//unit单位是分，换为元，再算一个小时的，乘以时间就是花费
    }

    public static function myJson($errArr, $data = null)
    {
        return response()->json(['errno' => $errArr["errno"], 'errmsg' => $errArr["errmsg"], 'result' => $data]);
    }

    public static function getUid()
    {
        $timeArr = explode(".", microtime(true));
        $timeStr = rand(1, 9) . rand(0, 9) . date('h') . substr($timeArr[0] . $timeArr[1], 7);
        return $timeStr;
    }

}