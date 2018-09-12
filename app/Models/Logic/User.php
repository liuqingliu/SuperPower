<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/22
 * Time: 16:41
 */
namespace App\Models\Logic;

use App\Models\Order as ChargeOrder;

class User
{

    public static function isNewUser($openid, $createTime)
    {
        $flag = (time()-strtotime($createTime)) < Common::ONE_WEEK_SECONDES;
        $orderCount = ChargeOrder::where("openid",$openid)->count();
        return $flag && !$orderCount;
    }
}