<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/21
 * Time: 14:21
 */

namespace App\Http\Controllers;

use App\Models\Logic\Common;
use App\Models\User;
use Illuminate\Support\Facades\Log;

//这里用来处理微信消息
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
        $app->server->push(function ($message) {
            Log::info('message:' . serialize($message));
            return "";
        });

        return $app->server->serve();
    }

    public function createWechatMenu()
    {
        $buttons = [
            [
                "type" => "view",
                "name" => "用户首页",
                "url" => "https://".Common::DOMAIN."/user/center"
            ],
            [
                "type" => "view",
                "name" => "经销商首页",
                "url" => "https://".Common::DOMAIN."/dealer/center"
            ],
            [
                "name" => "快捷方式",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "电卡充值",
                        "url" => "https://".Common::DOMAIN."/electric/cardorderpay"
                    ],
                ],
            ]
        ];
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_ADMIN && $userInfo->user_status == Common::USER_STATUS_DEFAULT) {
            $app = app('wechat.official_account');
            $app->menu->create($buttons);
            echo "create ok";
        } else {
            echo "非法用户";
        }
    }
}