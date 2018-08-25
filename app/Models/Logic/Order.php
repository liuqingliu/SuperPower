<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/18
 * Time: 15:52
 */
namespace App\Models\Logic;
class Order
{
    public static $payMoneyList = [
        "2" => [
            "real_price" => 2,
            "given_price" => 0,
        ],
        "30" => [
            "real_price" => 30,
            "given_price" => 1,
        ],
        "50" => [
            "real_price" => 50,
            "given_price" => 3,
        ],
        "100" => [
            "real_price" => 100,
            "given_price" => 5,
        ],
        "200" => [
            "real_price" => 200,
            "given_price" => 12,
        ],
        "300" => [
            "real_price" => 300,
            "given_price" => 20,
        ]
    ];

    const PAY_METHOD_WECHAT = 1;

    const ORDER_STATUS_DEFAULT = 0;
    const ORDER_STATUS_SUCCESS = 1;//成功
    const ORDER_STATUS_FAILED = 2;//失败
    const ORDER_STATUS_CLOSED = 3;//关闭

    public static $payMethodList = [
        self::PAY_METHOD_WECHAT => "weichat"
    ];
}