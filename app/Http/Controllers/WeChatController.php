<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/21
 * Time: 14:21
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class WeChatController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function($message){
            Log::info('message:'.serialize($message));
            return "欢迎关注 朗畅智能！";
        });

        return $app->server->serve();
    }
}