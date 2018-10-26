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
    const ONE_HOUR_SECONDES = 3600;
    const ONE_MINUTE_SECONDES = 60;

    //经销商，设备筛选
    const SHOW_HUIZONG_TYPE_JXS = 1;
    const SHOW_HUIZONG_TYPE_DEV = 2;

    //资金流水
    const CASH_TYPE_SHARE = 1;//经销商流水
    const CASH_TYPE_DEVIC = 2;//设备充电
    const CASH_STATUS_INCOME = 1;//进入
    const CASH_STATUS_OUT = 2;//支出

    //session_key
    const SESSION_KEY_USER = "user_info";
    const SESSION_KEY_DEALER = "dealer_user_info";

    //iot状态
    const STATUS_SEND_SUCCESS = 1;

    //domain
    const DOMAIN = "cxm.lcint.cn";

    //mail_exception_wechat_order
    public static $emailOferrorForWechcatOrder = [
        "609163616@qq.com"
    ];

    //经销商数据
    public static $dealers = [
        self::USER_TYPE_JXS,
        self::USER_TYPE_SJXS,
        self::USER_TYPE_ADMIN
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
        return $org;
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

    public static function getPrexZero($str, $len=5)
    {
        return str_pad($str,$len,"0",STR_PAD_LEFT);
    }

    public static function getLeftTime($totalTime, $createTime)
    {
        $leftTime = $totalTime - (time()-strtotime($createTime));
        $leftTime = max($leftTime, 0);
        return self::getPrexZero($leftTime);
    }

    public static function isPhone($phone)
    {
        $preg =  '/^(13[0-9]|14[579]|15[0-3,5-9]|166|17[0135678]|18[0-9])\\d{8}$/';
        return (bool)preg_match($preg, $phone);
    }
}