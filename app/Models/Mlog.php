<?php
namespace App\Models;
use Illuminate\Support\Facades\Log;
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 20:59
 */

class Mlog
{
    public static function myLog($info, $level="info", $file=""){
        if(!empty($file)){
            Log::useFiles(storage_path().'{$file}')->$level($info);
        }else{
            Log::$level($info);
        }
    }
}