<?php

namespace App\Http\Middleware;

use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use Closure;

class DealerLogin
{
    public function handle($request, Closure $next)
    {
        // 执行动作
        $flag = 0;
        $userInfo = session(Common::SESSION_KEY_USER);
        if (empty($userInfo)) {
            $flag = 1;
        }
        if (!in_array($userInfo->user_type, Common::$dealers)) {
            $flag = 1;
        }
        if ($userInfo->user_status==Common::USER_STATUS_FREEZONE) {
            $flag = 1;
        }
        if($flag){
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