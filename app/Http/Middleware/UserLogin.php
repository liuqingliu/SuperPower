<?php

namespace App\Http\Middleware;

use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Session;

class UserLogin
{
    public function handle($request, Closure $next)
    {
        // 执行动作
        $wxUser = session('wechat.oauth_user');
        if (empty($wxUser)) {
            return redirect('/user/center?redirectback='.$request->url);
        }else{
            $userInfo = User::where("openid",$wxUser['default']->id)->first();
            if (empty($userInfo)) {
                return redirect('/user/center?redirectback='.$request->url);
            }
        }

        return $next($request);
    }
}