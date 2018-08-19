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
            "send_price" => 0,
        ],
        "30" => [
            "real_price" => 29,
            "send_price" => 1,
        ],
        "50" => [
            "real_price" => 50,
            "send_price" => 3,
        ],
        "100" => [
            "real_price" => 100,
            "send_price" => 5,
        ],
        "200" => [
            "real_price" => 200,
            "send_price" => 12,
        ],
        "300" => [
            "real_price" => 300,
            "send_price" => 20,
        ]
    ];

    public static $payMethodList = [
        "1" => "weichat"
    ];
}