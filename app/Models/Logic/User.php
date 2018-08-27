<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/22
 * Time: 16:41
 */
namespace App\Models\Logic;

use App\Models\UserOrder;

class User
{

    public static function isNewUser($openid, $createTime)
    {
        $flag = (time()-strtotime($createTime)) < Common::ONE_WEEK_SECONDES;
        $orderCount = UserOrder::where("openid",$openid)->count();
        return $flag && !$orderCount;
    }
}