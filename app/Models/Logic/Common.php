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
    public static function getNeedArray($needArr, $org)
    {
        $res = [];
        foreach ($needArr as $value) {
            $res["{$value}"] = isset($org["{$value}"]) ? $org["{$value}"] : "";
        }
        return $res;
    }

    public static function getCost($unitPrice, $time)
    {
        return ($unitPrice * 0.01 * 1.0 / 60.0) * $time;//unit单位是分，换为元，再算一个小时的，乘以时间就是花费
    }

}