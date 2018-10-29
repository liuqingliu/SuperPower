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
    public static $errSys = ["errno"=>"3","errmsg"=>"系统错误,请稍后再试"];
    public static $errNotSelfUser = ["errno" => 4, "errmsg" => "不是用户本人"];
    public static $errChargingStatus = ["errno" => 5, "errmsg" => "充电订单状态有误"];
    public static $errNet = ["errno" => 6, "errmsg" => "网络错误,请稍后再试"];
    public static $errPassword = ["errno" => 7, "errmsg" => "密码错误"];
    public static $errOrderNotExist = ["errno" => 8, "errmsg" => "订单不存在"];
    public static $errUserInfoExpired = ["errno" => 9, "errmsg" => "用户信息已过期,请重新登录"];
    public static $errElectricCardEmpaty = ["errno" => 10, "errmsg" => "卡号不存在或未激活"];
    public static $errInvalidRequest = ["errno" => 11, "errmsg" => "非法请求"];
    public static $errCreateOrderFail = ["errno" => 12, "errmsg" => "创建订单失败"];
    public static $errNotLogin = ["errno" => 13, "errmsg" => "用户信息有误，请刷新重新登陆"];
    public static $errWechatPayPre = ["errno" => 14, "errmsg" => "微信接口有误，请刷新重试"];
    public static $errCallSendInvalid = ["errno" => 15, "errmsg" => "请求太频繁,请1分钟后再试"];
    public static $errSendFail = ["errno" => 16, "errmsg" => "短信发送失败，请等会儿再试"];
    public static $errPhoneAlreadyBind = ["errno" => 17, "errmsg" => "短信发送失败，请等会儿再试"];
    public static $errUserMoneyNotEnough = ["errno" => 18, "errmsg" => "余额不足,请充值"];
    public static $errPortUserd = ["errno" => 19, "errmsg" => "端口已被占用"];
    public static $errPortInvalid = ["errno" => 20, "errmsg" => "无效端口"];
    public static $errOrderStatus = ["errno" => 21, "errmsg" => "订单状态有误"];
    //dealer
    public static $errCardNotExist = ["errno" => 22, "errmsg" => "电卡不存在"];
    public static $errNotPermit = ["errno" => 23, "errmsg" => "权限不足"];
    public static $errNotEnough = ["errno" => 24, "errmsg" => "余额不足，不能提现"];
    public static $notFindUser = ["errno" => 25, "errmsg" => "用户信息不存在"];
    public static $errPasswordExist = ["errno" => 26, "errmsg" => "密码已存在"];
    public static $errIdcard = ["errno" => 27, "errmsg" => "身份证信息不匹配"];
    public static $errPhoneEmpty = ["errno" => 28, "errmsg" => "手机号为空"];
    public static $errEquipmentStatus = ["errno" => 29, "errmsg" => "设备状态有误"];
}