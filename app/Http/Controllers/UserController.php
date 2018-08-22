<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;
use App\Models\Dealer;
use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Models\Logic\Order;
use App\Models\Logic\User as UserLogic;
use App\Models\User;
use App\Models\UserOrder;
use App\Rules\ValidatePhoneRule;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function center(Request $request)
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = session('user_info');
        if(empty($wxUser) || !isset($wxUser["default"])){
            dd("请求非法");
        }
        if(empty($userInfo)) {
            $userInfoReal = User::where("openid",$wxUser['default']->id)->where("user_status", Common::USER_TYPE_NORMAL)->first();
            if (empty($userInfoReal)) {
                User::create([
                    'openid'=>$wxUser['default']->id,
                    'user_id'=>Common::getUid(),
                    'headimgurl'=>$wxUser['default']->avatar,
                    'nickname' => $wxUser['default']->nickname,
                    'ip' => $request->getClientIp(),
                    'user_last_login' => date("Y-m-d H:i:s")
                ]);
                $userInfoReal = User::where("openid",$wxUser['default']->id)->where("user_status", Common::USER_TYPE_NORMAL)->first();
            }
            session(['user_info' => $userInfoReal]);
            $userInfo = $userInfoReal;
        }

        return view('user/center',[
            "user_info" => Common::getNeedObj([
                "phone",
                "headimgurl",
                "nickname",
                "user_money",
                "user_id",
                "user_type",
            ], $userInfo),
        ]);
    }

    public function detail()
    {
        $userInfo = session('user_info');
        if (empty($userInfo)) {
            return redirect('/user/center');
        }

        return view('user/detail',[
            "user_info" => Common::getNeedObj(["nickname","phone","user_id","user_money","charging_total_cnt","charging_total_time"],$userInfo)
        ]);
    }

    public function bindphone()
    {
        $userInfo = session("user_info");
        if (empty($userInfo)) {
            return redirect('/user/center');
        }
        return view('user/bindphone',[
            "user_info" => Common::getNeedObj(["phone"], $userInfo)
        ]);
        return view('center/index');
    }

    public function order()
    {
        $userInfo = session("user_info");
        if(empty($userInfo)){
            return redirect('/user/center');
        }
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        return view('user/order',[
            "pay_money_list" => $payMethodList,
            "pay_method_list" => $payMoneyList,
        ]);
    }

    public function orderanswser(Request $request)
    {
        $userInfo = session("user_info");
        if(empty($userInfo)){
            return redirect('/user/center');
        }
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|string|max:30|min:16',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $orderInfo = UserOrder::where("openid", $userInfo["openid"])
            ->where("order_id", $request->order_id)
            ->first();
        if (empty($orderInfo)) {
            return Common::myJson(ErrorCall::$errOrderNotExist);
        }
        return view('user/orderanswser',["pay_status" => $orderInfo["order_status"]]);
    }

    public function about()
    {
        $userInfo = session("user_info");
        if(empty($userInfo)){
            return redirect('/user/center');
        }
        return view('user/about');
    }

    //更新用户手机号
    public function updateUserPhone(Request $request)
    {
        $userInfo = session("user_info");
        if(empty($userInfo)){
            return Common::myJson(ErrorCall::$errUserInfoExpired, ["result" => "请重新登录"]);
        }
        $validator = Validator::make($request->all(), [
            'user_phone' => ['required',new ValidatePhoneRule],
            'user_password' => 'sometimes|string|max:20|min:6'
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        if ($userInfo->user_type!=Common::USER_TYPE_NORMAL) {
            if (empty($request->user_password)) {
                return Common::myJson(ErrorCall::$errParams, $validator->errors());
            } elseif ($request->user_password != $userInfo->dealer->password) {
                return Common::myJson(ErrorCall::$errPassword, $validator->errors());
            }
        }
        $userInfo->phone = $request->user_phone;
        $res = $userInfo->save();
        $resDealer = $userInfo->dealer->save();
        if($res && $resDealer){
            return Common::myJson(ErrorCall::$errSucc, $res);
        }else{
            return Common::myJson(ErrorCall::$errSys, ["res_1" => $res, "res_2" => $resDealer]);
        }
    }
}