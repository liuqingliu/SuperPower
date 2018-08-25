<?php

namespace App\Http\Middleware;

use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use Closure;

class UserLogin
{
    public function handle($request, Closure $next)
    {
        // 执行动作
        $userInfo = session(Common::SESSION_KEY_USER);
        if (empty($userInfo)) {
            return redirect('/user/center?redirectback='.$request->url);
        }
        return $next($request);
    }
}