<?php

namespace App\Http\Middleware;

use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Models\User;
use Closure;

class DealerLogin
{
    public function handle($request, Closure $next)
    {
        // 执行动作
        $wxUser = session('wechat.oauth_user');
        if (empty($wxUser) ){
            return redirect('/prompt')->with([
                'message' => ErrorCall::$errNotLogin["errmsg"],
                'url' => '/user/center',
                'jumpTime' => 3,
                'status' => 'error'
            ]);
        }
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        if (empty($userInfo) || empty($userInfo->dealer) || $userInfo->user_status == Common::USER_STATUS_FREEZONE ||  $userInfo->user_type == Common::USER_TYPE_NORMAL) {
            return redirect('/prompt')->with([
                'message' => ErrorCall::$errNotLogin["errmsg"],
                'url' => '/user/center',
                'jumpTime' => 3,
                'status' => 'error'
            ]);
        }
        return $next($request);
    }
}