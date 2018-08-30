<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/8/30
 * Time: 16:22
 */
namespace App\Http\Controllers;

use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class ApiController extends Controller
{
    public function getCaptcha()
    {
        return Common::myJson(ErrorCall::$errSucc, captcha_src());
    }

    public function sendMessage()
    {
        $config = config('easysms');
//        dd($app);
        $easySms = new EasySms($config);
        $easySms->send(13188888888, $message);
        $easySms->send('15701160070', [
            'content'  => '',
            'template' => 'SMS_143560259',
            'data' => [
                'code' => 6379
            ],
        ]);
    }
}