<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 17:34
 */
namespace App\Models\Logic;

class Charge
{
    //充电
    const ORDER_RECHARGE_STATUS_DEFAULT = 0;//未开始充电
    const ORDER_RECHARGE_STATUS_CHARGING = 1;//正在充电
    const ORDER_RECHARGE_STATUS_END = 2;//充电结束
    const ORDER_RECHARGE_STATUS_CACEL = 3;//取消充电

    const ORDER_RECHARGE_TYPE_CARD = 0;//电卡
    const ORDER_RECHARGE_TYPE_USER = 1;//用户

    public static $chargeTypeList = [
        0,2,4,6,8,10
    ];
}