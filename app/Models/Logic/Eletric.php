<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/6
 * Time: 13:57
 */
namespace App\Models\Logic;

class Eletric
{
    //用电终端设备状态
    const DEVICE_STATUS_DEFAULT = 0;//默认
    const DEVICE_STATUS_ACTIVE = 1;//正常
    const DEVICE_STATUS_DISABLED = 2;//禁用
    //终端网络
    const DEVICE_NET_STATUS = 0;//正常
    const DEVICE_NET_ERROR = 1;//网络断开

    //电卡状态
    const CARD_STATUS_DEFAULT = 0;//正常
    const CARD_STATUS_FROZEN = 1;//冻结

    //port占用情况
    const PORT_STATUS_DEFAULT = 0;//未使用
    const PORT_STATUS_USE = 1;//使用

    const DEVICE_VERSION = "2";
    const DEVICE_VERSION_BIN = "ADIOJOSDJFALDJFLISDJF";
}