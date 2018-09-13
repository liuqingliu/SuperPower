<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;
use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Models\Logic\Order;
use App\Models\Logic\User as UserLogic;
use App\Models\Logic\Snowflake;
use App\Models\User;
use App\Models\Order as ChargeOrder;
use App\Rules\ValidatePhoneRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function center(Request $request)
    {
        $userInfo = User::find(1);
        return view('user/center',[
            "user_info" => Common::getNeedObj([
                "phone",
                "headimgurl",
                "nickname",
                "user_money",
                "user_id",
                "user_type",
                "api_token"
            ], $userInfo),
        ]);

        $wxUser = session('wechat.oauth_user');
        $userInfo = session(Common::SESSION_KEY_USER);
        if(empty($wxUser) || !isset($wxUser["default"])){
            dd("请求非法");
        }
        if(empty($userInfo)) {
            $userInfoReal = User::where("openid",$wxUser['default']->id)->first();
            if($userInfoReal["user_status"]==Common::USER_STATUS_FREEZONE) {
                dd("非法用户，请联系管理员");
            }
            if (empty($userInfoReal)) {
                User::create([
                    'openid'=>$wxUser['default']->id,
                    'user_id'=>Common::getUid(),
                    'headimgurl'=>$wxUser['default']->avatar,
                    'nickname' => $wxUser['default']->nickname,
                    'ip' => $request->getClientIp(),
                    'user_last_login' => date("Y-m-d H:i:s"),
                    'api_token' => md5($wxUser['default']->id."cxm*#*".time()),
                ]);
                $userInfoReal = User::where("openid",$wxUser['default']->id)->where("user_status", Common::USER_TYPE_NORMAL)->first();
            }
            $userInfoReal->user_last_login = date("Y-m-d H:i:s");
//            $userInfoReal->api_token = md5($wxUser['default']->id."cxm*#*".time());//脚本批量更新
            $res = $userInfoReal->save();
            if(!$res){
                dd("请刷新重试");
            }
            session([Common::SESSION_KEY_USER => $userInfoReal]);
            $userInfo = $userInfoReal;
        }
        $userInfo = User::find(1);
        return view('user/center',[
            "user_info" => Common::getNeedObj([
                "phone",
                "headimgurl",
                "nickname",
                "user_money",
                "user_id",
                "user_type",
                "api_token"
            ], $userInfo),
        ]);
    }

    public function detail()
    {
//        $userInfo = session(Common::SESSION_KEY_USER);
        $userInfo = User::find(1);
        return view('user/detail',[
            "user_info" => Common::getNeedObj(["nickname","phone","user_id","user_money","charging_total_cnt","charging_total_time","headimgurl"],$userInfo)
        ]);
    }

    public function bindphone()
    {
//        $userInfo = session(Common::SESSION_KEY_USER);
        $userInfo = User::find(1);
        return view('user/bindphone',[
            "user_info" => Common::getNeedObj(["phone"], $userInfo)
        ]);
        return view('center/index');
    }

    public function order(Request $request)
    {
//        $userInfo = session(Common::SESSION_KEY_USER);
        $userInfo = User::find(1);
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        return view('user/order',[
            "pay_money_list" => $payMoneyList,
            "pay_method_list" => $payMethodList,
            "new_user" => UserLogic::isNewUser($userInfo->openid, $userInfo->created_at),
            "user_money" => $userInfo->user_money,
        ]);
    }

    public function orderanswser(Request $request)
    {
//        $userInfo = session(Common::SESSION_KEY_USER);
        $userInfo = User::find(1);
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|string|max:30|min:16',
        ]);
        if ($validator->fails()) {
            redirect("user/center");
        }
        $orderInfo = ChargeOrder::where("openid", $userInfo["openid"])
            ->where("order_id", $request->order_id)
            ->first();
        if (empty($orderInfo)) {
            redirect("user/center");
        }
        return view('user/orderanswser',["success_flag" => ($orderInfo["order_status"] == Order::ORDER_STATUS_SUCCESS)]);
    }

    public function about()
    {
        return view('user/about');
    }

    //更新用户手机号
    public function updateUserPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_phone' => ['required',new ValidatePhoneRule],//,"exists:users,phone"
            'captcha' => 'required|captcha'
//            'user_password' => 'sometimes|string|max:20|min:6'
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        var_dump("13");exit;
        $userInfo = Auth::guard("api")->user();
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

//    创建用户充值订单
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay_money_type' => 'required|int|in:'.implode(",",array_keys(Order::$payMoneyList)),
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $userInfo = User::find(1);
        //可以充值了？就需要判断提交上来的是否有效
        $price = Order::$payMoneyList[$request->pay_money_type]["real_price"] * 100;//真实充值
        $extends = "";

        if(UserLogic::isNewUser($userInfo->openid, $userInfo->created_at)){
            $extends = json_encode(["given_price" => Order::$payMoneyList[$request->pay_money_type]["given_price"] * 100]);
        }

        $createParams = [
            "order_id" => Snowflake::nextId(),
            "price" => $price * 100,
            "extends" => $extends,
            "openid" => $userInfo->openid,
            "order_type" => Order::PAY_METHOD_WECHAT,
        ];
        $res = ChargeOrder::create($createParams);
        if(!$res){
            return Common::myJson(ErrorCall::$errCreateOrderFail);
        }
        //创建微信支付
        $app = app('wechat.payment');
        $result = $app->order->unify([
            'body' => '充小满-充电了',
            'out_trade_no' => $createParams["order_id"],
            'total_fee' => $price,
            'trade_type' => 'JSAPI',
            'openid' => $userInfo->openid,
            'notify_url' => 'http://'.Common::DOMAIN.'/payment/wechatnotify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
        ]);

        if(isset($result["prepay_id"])) {
            $jssdk = $app->jssdk->bridgeConfig($result["prepay_id"], false);
            Log::info("jssdk:".serialize($jssdk));
            return Common::myJson(ErrorCall::$errSucc,$jssdk);
        }else{
            $orderInfo = ChargeOrder::where("order_id",$createParams["order_id"])->first();
            $orderInfo->order_status = Order::ORDER_STATUS_CLOSED;
            $orderInfo->save();
            return Common::myJson(ErrorCall::$errWechatPayPre,$result["err_code_des"]);
        }
    }

    public function getOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => "required|exists:orders"
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $orderInfo = ChargeOrder::where("order_id",$request->order_id)->first();
        if(empty($orderInfo)){
            return Common::myJson(ErrorCall::$errOrderNotExist, $validator->errors());
        }
        return Common::myJson(ErrorCall::$errSucc, ["order_status" => $orderInfo->order_status]);
    }
}



