<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;

use App\Models\ChargingEquipment;
use App\Models\ElectricCard;
use App\Models\ElectricCardOrder;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Models\Logic\Order;
use App\Models\RechargeOrder;
use App\Models\Logic\User as UserLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ElectricController extends Controller
{
    public function cardorderpay()
    {
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        return view('electric/cardorderpay',[
            "pay_money_list" => $payMoneyList,
            "pay_method_list" =>$payMethodList ,
        ]);
    }

    public function cardorderpayanswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => 'required|string|max:11|min:11|unique:ElectricCard'
        ]);
        if ($validator->fails()) {
            return redirect("/user/center");
        }
        $electricCardOrders = ElectricCardOrder::where("card_id",$request->card_id)->select(["order_status"])->first();
        return view('electric/cardorderpayanswer',[
            "order_status" => $electricCardOrders->order_status
        ]);
    }

    public function recharge()
    {
        $rechargeInfo = RechargeOrder::find(1);
        $chargingEquipment = $rechargeInfo->chargingEquipment;

        $unitMoney = $rechargeInfo->recharge_unit_money;
        $costTime = $rechargeInfo->recharge_time;
        return view('electric/recharge',[
            "charge_price" => $unitMoney,
            "charge_time" => $costTime,
            "charge_cost" => Common::getCost($unitMoney, $costTime),
            "socket_info" => $chargingEquipment->address.$rechargeInfo->jack_id."号插座",
        ]);
    }

    public function choosesocket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devid' => 'required|int|max:20|min:10',
        ]);
        if ($validator->fails()) {
            return redirect('/prompt')->with(['message'=>ErrorCall::$errParams["errmsg"],'url' =>'/user/center', 'jumpTime'=>3,'status'=>'error']);
        }
        //获取当前终端的基本信息
        $device = ChargingEquipment::where("devid",$request->devid)->first();
        return view('electric/choosesocket',[
            "device_info" => Common::getNeedObj([
                "ebquipment_status ",
                "net_status",
                "equipment_id",
                "province",
                "city",
                "area",
                "street",
                "address",
                "manager_phone",
                "charging_unit_price",
                "jack_info",
                "board_info",//存储board1
            ], $device),
            "charge_type_list" => Charge::$chargeTypeList,
        ]);
    }

    public function rechargelog()
    {
        $userInfo = session("user_info");
        $rechareList = RechargeOrder::where("recharge_str", $userInfo->openid)->get();
        $res = [];
        foreach ($rechareList as $recharge) {
            $tmp = [];
            $device = $recharge->chargingEquipment;
            $tmp["device_address"] = $device->address;
            $tmp["recharge_time"] = $recharge->recharge_time;
            $tmp["recharge_price"] = $recharge->recharge_price;
            $tmp["date"] = date("Y-m-d",strtotime($recharge->created_at));
            $tmp["time_s"] = date("H:i",strtotime($recharge->created_at));
            $tmp["time_e"] = date("H:i",strtotime($recharge->created_at)+$recharge->recharge_time);
            $res[] = $tmp;
        }
        return view('electric/rechargelog',[
            "charge_list" => $res,
        ]);
    }

    public function getRechargeLog(Request $request)
    {
        $userInfo = Auth::guard("api")->user();
        $validator = Validator::make($request->all(), [
            'count' => 'sometimes|int|max:20|min:1',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $count = isset($request->count) ? (int)$request->count : 10;
        $data = RechargeOrder::with("chargingEquipment")->where("recharge_str", $userInfo->openid)->orderBy('created_at', 'desc')->paginate($count);
        return Common::myJson(ErrorCall::$errSucc, $data->toArray());
    }

    //停止充电
    public function stopChargingOrder(Request $request)
    {
        $userInfo = Auth::guard("api")->user();
        $chargingOrderInfo = RechargeOrder::where('recharge_str',$userInfo->openid)->first();
        if($chargingOrderInfo["user_id"]!=$request->order_id){
            return Common::myJson(ErrorCall::$errNotSelfUser);
        }
        if($chargingOrderInfo["recharge_status"]!=Common::CHARGING_STATUS_DEFAULT){
            return Common::myJson(ErrorCall::$errChargingStatus);
        }
        $chargingOrderInfo->recharge_status = Common::CHARGING_STATUS_STOP;//停止充电
        $chargingOrderInfo->recharge_time = time()-strtotime($chargingOrderInfo->created_at);//单位秒
        $res = $chargingOrderInfo->save();
        if(!$res){
            return Common::myJson(ErrorCall::$errNet);
        }
        //todo 调用阿里云接口
        return Common::myJson(ErrorCall::$errSucc);
    }
    //获取电卡信息
    public function getElectricCardInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => 'required|int|max:20|min:10',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $electricCardInfo = ElectricCard::where("card_id", $request->electric_card_id)->where("card_status", Common::ELETRIC_CARD_STATUS_DEFAULT)->first();
        if(empty($electricCardInfo)) {
            return Common::myJson(ErrorCall::$errElectricCardEmpaty);
        }
        return Common::myJson(ErrorCall::$errSucc, ["card_id" => $electricCardInfo->card_id,  "money" => $electricCardInfo->money]);
    }

    //创建电卡充值订单
    public function createOrder(Request $request)
    {
        $userInfo = Auth::guard("api")->user();//是否正常登陆过
        $validator = Validator::make($request->all(), [
            'pay_money_type' => 'required|int|in:'.implode(",",array_keys(Order::$payMoneyList)),
            'card_id' => 'required|string|max:11|min:11|unique:ElectricCard'
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        //可以充值了？就需要判断提交上来的是否有效
        $price = Order::$payMoneyList[$request->pay_money_type]["real_price"] * 100;//真实充值
        $extends = "";

        $createParams = [
            "order_id" => Snowflake::nextId(),
            "card_id" => $request->card_id,
            "price" => $price * 100,
            "extends" => $extends,
            "openid" => $userInfo->openid,
            "order_type" => Order::PAY_METHOD_WECHAT,
        ];
        $res = ElectricCardOrder::create($createParams);
        if(!$res){
            return Common::myJson(ErrorCall::$errCreateOrderFail);
        }
        //创建微信支付
        $app = app('wechat.payment');
        $result = $app->order->unify([
            'body' => '充小满-充电了',
            'out_trade_no' => $createParams["order_id"],
            'total_fee' => $price * 100,
            'trade_type' => 'JSAPI',
            'openid' => $userInfo->openid,
            'notify_url' => 'http://www.babyang.top/payment/wechatnotify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
        ]);

        if(isset($result["prepay_id"])) {
            $jssdk = $app->jssdk->bridgeConfig($result["prepay_id"], false);
            Log::info("jssdk:".serialize($jssdk));
            return Common::myJson(ErrorCall::$errSucc,$jssdk);
        }else{
            $orderInfo = ElectricCardOrder::where("order_id",$createParams["order_id"])->first();
            $orderInfo->order_status = Order::ORDER_STATUS_CLOSED;
            return Common::myJson(ErrorCall::$errWechatPayPre,$result["err_code_des"]);
        }
    }
}