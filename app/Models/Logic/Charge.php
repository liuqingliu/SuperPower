<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 17:34
 */
namespace App\Models\Logic;

use App\Events\SendWulian;

class Charge
{
    //充电
    const ORDER_RECHARGE_STATUS_DEFAULT = 0;//未开始充电
    const ORDER_RECHARGE_STATUS_CHARGING = 1;//正在充电
    const ORDER_RECHARGE_STATUS_END = 2;//充电结束
    const ORDER_RECHARGE_STATUS_FAILED = 3;//充电失败
    const ORDER_RECHARGE_STATUS_ENDING = 4;//充电结束ING

    const ORDER_RECHARGE_TYPE_CARD = 0;//电卡
    const ORDER_RECHARGE_TYPE_USER = 1;//用户

    public static $chargeTypeList = [
        0 => [
            "total_time" => 8 * Common::ONE_HOUR_SECONDES,
        ],
        2 => [
            "total_time" => 2 * Common::ONE_HOUR_SECONDES,
        ],
        4 => [
            "total_time" => 4 * Common::ONE_HOUR_SECONDES,
        ],
        6 => [
            "total_time" => 6 * Common::ONE_HOUR_SECONDES,
        ],
        8 => [
            "total_time" => 8 * Common::ONE_HOUR_SECONDES,
        ],
    ];

    public static function sendWulianThree($devid, $answer)
    {
        $cnt = 0;
        while ($cnt <= 10) {
            sleep(1);
            if ($cnt % 5 == 0) {
                event(new SendWulian($devid, $answer));//下发3次，直到有回复过来
            }
        }
    }
}