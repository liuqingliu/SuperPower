<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/22
 * Time: 16:41
 */
namespace App\Models\Logic;

class User
{

    public static function isNewUser($createTime)
    {
        return (time()-strtotime($createTime)) < Common::ONE_WEEK_SECONDES;
    }
}