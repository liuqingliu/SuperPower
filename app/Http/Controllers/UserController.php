<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;
use App\Models\Logic\Charge;
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
use stdClass;


class UserController extends Controller
{
    public function center(Request $request)
    {
//        Session()->flush();
//        echo "1";
//        return;
        $wxUser = session('wechat.oauth_user');
        if(empty($wxUser) || !isset($wxUser["default"])){
            dd("请求非法");
        }
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        if (empty($userInfo)) {
            User::create([
                'openid'=>$wxUser['default']->id,
                'user_id'=>Common::getUid(),
                'headimgurl'=>$wxUser['default']->avatar,
                'nickname' => $wxUser['default']->nickname,
                'ip' => $request->getClientIp(),
                'user_last_login' => date("Y-m-d H:i:s"),
                'api_token' => md5($wxUser['default']->id."cxm*#*".time()),
            ]);
            $userInfo = User::where("openid",$wxUser['default']->id)->first();
        }
        if($userInfo->user_status==Common::USER_STATUS_FREEZONE) {
            dd("非法用户，请联系管理员");
        }
        $app = app('wechat.official_account');
        $wxJssdkconfig = $app->jssdk->buildConfig(array('checkJsApi', 'scanQRCode'), false);
        $showUser = new stdClass();
        $showUser->headimgurl = $userInfo->headimgurl;
        $showUser->nickname = $userInfo->nickname;
        $showUser->user_id = $userInfo->user_id;
        $showUser->phone = $userInfo->phone;
        $showUser->user_money = $userInfo->user_money * 0.01;
        $showUser->user_type = $userInfo->user_type;
        return view('user/center',[
            "user_info" => $showUser,
            "wxjssdk" => $wxJssdkconfig,
            "new_user" => UserLogic::isNewUser($userInfo->openid, $userInfo->created_at),
        ]);
    }

    public function detail()
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        return view('user/detail',[
            "user_info" => $userInfo
        ]);
    }

    public function bindphone()
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        $outUserInfo = [
            "user_info" => $userInfo,
        ];
        if(!empty($userInfo->dealer)){
            $outUserInfo["is_set_pwd"] = !empty($userInfo->dealer->password) ? true : false;
        }

        return view('user/bindphone',$outUserInfo);
    }

    public function order(Request $request)
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        return view('user/order',[
            "pay_money_list" => $payMoneyList,
            "pay_method_list" => $payMethodList,
            "new_user" => UserLogic::isNewUser($userInfo->openid, $userInfo->created_at),
            "user_money" => $userInfo->user_money * 1.0/ 100,
        ]);
    }

    public function orderanswser(Request $request)
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
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
            'verifyCode' => 'required|verify_code',
            'user_password' => 'sometimes|string|max:20|min:6'
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
//        if ($userInfo->user_type!=Common::USER_TYPE_NORMAL) {
//            if (empty($request->user_password)) {
//                return Common::myJson(ErrorCall::$errParams, $validator->errors());
//            } elseif ($request->user_password != $userInfo->dealer->password) {
//                return Common::myJson(ErrorCall::$errPassword, $validator->errors());
//            }
//        }
        $userInfo->phone = $request->user_phone;
        $res = $userInfo->save();
//        $resDealer = $userInfo->dealer->save();
        if($res){
            return Common::myJson(ErrorCall::$errSucc, $res);
        }else{
            return Common::myJson(ErrorCall::$errSys);
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
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        //可以充值了？就需要判断提交上来的是否有效
        $price = Order::$payMoneyList[$request->pay_money_type]["real_price"] * 100;//真实充值
        $extends = "";

        if(UserLogic::isNewUser($userInfo->openid, $userInfo->created_at)){
            $extends = json_encode(["given_price" => Order::$payMoneyList[$request->pay_money_type]["given_price"] * 100]);
        }

        $createParams = [
            "order_id" => Snowflake::nextId(),
            "price" => $price,
            "extends" => $extends,
            "openid" => $userInfo->openid,
            "order_type" => Order::PAY_METHOD_WECHAT,
            "type" => Charge::ORDER_RECHARGE_TYPE_USER,
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
            'notify_url' => 'https://'.Common::DOMAIN.'/payment/wechatnotify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
        ]);

        if(isset($result["prepay_id"])) {
            $jssdk = $app->jssdk->bridgeConfig($result["prepay_id"], false);
            Log::info("jssdk:".serialize($jssdk));
            return Common::myJson(ErrorCall::$errSucc,$jssdk);
        }else{
            $orderInfo = ChargeOrder::where("order_id",$createParams["order_id"])->first();
            $orderInfo->order_status = Order::ORDER_STATUS_CLOSED;
            $orderInfo->save();
            return Common::myJson(ErrorCall::$errWechatPayPre,$result);
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



