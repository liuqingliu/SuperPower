<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */

namespace App\Http\Controllers;

use App\Events\SendWulian;
use App\Jobs\SendWulianQue;
use App\Models\ChargingEquipment;
use App\Models\ElectricCard;
use App\Models\Order as ChargeOrder;
use App\Models\EquipmentPort;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Eletric;
use App\Models\Logic\ErrorCall;
use App\Models\Logic\Order;
use App\Models\Logic\Snowflake;
use App\Models\RechargeOrder;
use App\Models\Logic\User as UserLogic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ElectricController extends Controller
{
    public function cardorderpay()
    {
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        return view('electric/cardorderpay', [
            "pay_money_list" => $payMoneyList,
            "pay_method_list" => $payMethodList,
        ]);
    }

    public function cardorderpayanswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => 'required|string|max:11|min:11|exist:orders'
        ]);
        if ($validator->fails()) {
            return redirect("/user/center");
        }
        $orders = ChargeOrder::where("card_id", $request->card_id)->select(["order_status"])->first();
        return view('electric/cardorderpayanswer', [
            "order_status" => $orders->order_status
        ]);
    }

    public function recharge()
    {
        $rechargeInfo = RechargeOrder::find(1);
        $chargingEquipment = $rechargeInfo->chargingEquipment;

        $unitMoney = $rechargeInfo->recharge_unit_money;
        $costTime = $rechargeInfo->recharge_end_time;
        return view('electric/recharge', [
            "charge_price" => $unitMoney,
            "charge_time" => $costTime,
            "charge_cost" => Common::getCost($unitMoney, $costTime),
            "socket_info" => $chargingEquipment->address . $rechargeInfo->jack_id . "号插座",
        ]);
    }

    public function choosesocket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devid' => 'required|int|max:20|min:10',
        ]);
        if ($validator->fails()) {
            return redirect('/prompt')->with([
                'message' => ErrorCall::$errParams["errmsg"],
                'url' => '/user/center',
                'jumpTime' => 3,
                'status' => 'error'
            ]);
        }
        $userInfo = session("user_info");
        $rechargeOrder = RechargeOrder::where("recharge_str", $userInfo->openid)->where("recharge_status",
            Charge::ORDER_RECHARGE_STATUS_CHARGING)->first();
        if (!empty($rechargeOrder)) {
            return redirect('/electric/recharge');
        }
        //获取当前终端的基本信息
        $device = ChargingEquipment::where("devid", $request->devid)->first();
        return view('electric/choosesocket', [
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
            $tmp["recharge_end_time"] = $recharge->recharge_end_time;
            $tmp["recharge_price"] = $recharge->recharge_price;
            $tmp["date"] = date("Y-m-d", strtotime($recharge->created_at));
            $tmp["time_s"] = date("H:i", strtotime($recharge->created_at));
            $tmp["time_e"] = date("H:i", strtotime($recharge->created_at) + $recharge->recharge_end_time);
            $res[] = $tmp;
        }
        return view('electric/rechargelog', [
            "charge_list" => $res,
        ]);
    }

    public function getRechargeLog(Request $request)
    {
        $userInfo = session("user_info");
        $validator = Validator::make($request->all(), [
            'count' => 'sometimes|int|max:20|min:1',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $count = isset($request->count) ? (int)$request->count : 10;
        $data = RechargeOrder::with("chargingEquipment")->where("recharge_str",
            $userInfo->openid)->orderBy('created_at', 'desc')->paginate($count);
        return Common::myJson(ErrorCall::$errSucc, $data->toArray());
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
        $electricCardInfo = ElectricCard::where("card_id", $request->electric_card_id)->where("card_status",
            Common::ELETRIC_CARD_STATUS_DEFAULT)->first();
        if (empty($electricCardInfo)) {
            return Common::myJson(ErrorCall::$errElectricCardEmpaty);
        }
        return Common::myJson(ErrorCall::$errSucc,
            ["card_id" => $electricCardInfo->card_id, "money" => $electricCardInfo->money]);
    }

    //创建电卡充值订单
    public function createOrder(Request $request)
    {
        $userInfo = session("user_info");//是否正常登陆过
        $validator = Validator::make($request->all(), [
            'pay_money_type' => 'required|int|in:' . implode(",", array_keys(Order::$payMoneyList)),
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
        $res = ChargeOrder::create($createParams);
        if (!$res) {
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

        if (isset($result["prepay_id"])) {
            $jssdk = $app->jssdk->bridgeConfig($result["prepay_id"], false);
            Log::info("jssdk:" . serialize($jssdk));
            return Common::myJson(ErrorCall::$errSucc, $jssdk);
        } else {
            $orderInfo = order::where("order_id", $createParams["order_id"])->first();
            $orderInfo->order_status = Order::ORDER_STATUS_CLOSED;
            return Common::myJson(ErrorCall::$errWechatPayPre, $result["err_code_des"]);
        }
    }

    //开插座
    public function openSocket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equipment_id' => 'required|string|min:15',
            'port' => 'required|int|max:10|min:0',
            'recharge_type' => 'required|int|in:' . implode(",", array_keys(Charge::$chargeTypeList)),
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
//        $userInfo = session("user_info");//是否正常登陆过
        $deviceInfo = ChargingEquipment::where("equipment_id", $request->equipment_id)->first();
        $userInfo = User::find(1);
        if ($userInfo->user_money < 200 || $userInfo->user_money < $deviceInfo->charging_unit_price * Charge::$chargeTypeList[$request->recharge_type]["total_time"]) {
            return Common::myJson(ErrorCall::$errUserMoneyNotEnough);
        }
        $portInfo = EquipmentPort::where("equipment_id", $request->equipment_id)->where("port",
            $request->port)->first();
        if (empty($portInfo)) {
            return Common::myJson(ErrorCall::$errPortInvalid);
        }
        if ($portInfo->status == Eletric::PORT_STATUS_USE) {
            return Common::myJson(ErrorCall::$errPortUserd);
        }
        //生成订单
        $orderInfo = [
            "order_id" => Snowflake::nextId(),
            "recharge_str" => $userInfo->openid,
            "equipment_id" => $request->equipment_id,
            "port" => $request->port,
            "recharge_total_time" => Charge::$chargeTypeList[$request->recharge_type]["total_time"],
            "recharge_unit_money" => $deviceInfo->charging_unit_price,
            "recharge_price" => $deviceInfo->charging_unit_price * Charge::$chargeTypeList[$request->recharge_type]["total_time"],
            "type" => Charge::ORDER_RECHARGE_TYPE_USER,
            "created_at" => date("Y-m-d H:i:s")
        ];

        try {
            DB::transaction(function () use ($orderInfo, $portInfo) {
                RechargeOrder::insert($orderInfo);
                $portInfo->status = Eletric::PORT_STATUS_USE;
                $portInfo->save();
            }, 5);
        } catch (\Exception $e) {
            Log::debug(__FUNCTION__ . ":" . serialize($request->all()));
            return Common::myJson(ErrorCall::$errSys);
        }

        $callArr = [
            "func" => "open",
            "order" => "{$orderInfo['order_id']}",
            "port" => intval($request->port),
            "left_time" => intval($orderInfo["recharge_total_time"])
        ];
        //通知下位机
        dispatch(new SendWulianQue($request->equipment_id, $callArr));
        return Common::myJson(ErrorCall::$errSucc);
    }

    //关闭插座
    //todo 微信推消息
    public function closeSocket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:recharge_orders',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $userInfo = User::find(1);
        $rechargeOrder = RechargeOrder::where("order_id", $request->order_id)->first();
        if (empty($rechargeOrder)) {
            return Common::myJson(ErrorCall::$errOrderNotExist, $validator->errors());
        }
//        if($rechargeOrder->recharge_str!=$userInfo->openid){
//            return Common::myJson(ErrorCall::$errNotSelfUser, $validator->errors());
//        }
//        if($rechargeOrder->recharge_status!=Charge::ORDER_RECHARGE_STATUS_CHARGING){
//            return Common::myJson(ErrorCall::$errOrderStatus, $validator->errors());
//        }
        $portInfo = EquipmentPort::where("equipment_id", $rechargeOrder->equipment_id)->where("port",
            $rechargeOrder->port)->first();
        try {
            DB::transaction(function () use ($rechargeOrder, $portInfo) {
                $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_ENDING;
                $rechargeOrder->recharge_end_time = date("Y-m-d H:i:s");
                $rechargeOrder->recharge_price = $rechargeOrder->recharge_unit_money * (time() - strtotime($rechargeOrder->updated_at));
                $rechargeOrder->save();
                $portInfo->status = Eletric::PORT_STATUS_DEFAULT;
                $portInfo->save();
                $userInfo = User::where("openid", $rechargeOrder->recharge_str)->first();
                $userInfo->user_money = $userInfo->user_money - $rechargeOrder->price;
                $userInfo->save();
            }, 5);
        } catch (\Exception $e) {
            Log::debug(__FUNCTION__ . ":" . serialize($e->getMessage()));
            return Common::myJson(ErrorCall::$errSys);
        }
        $callArr = [
            "func" => "cancel",
            "order" => $rechargeOrder->order_id,
        ];
        //通知下位机
        dispatch(new SendWulianQue($request->equipment_id, $callArr));//下发3次，直到有回复过来
        return Common::myJson(ErrorCall::$errSucc);
    }

    public function getOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => "required|exists:recharge_orders"
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $orderInfo = RechargeOrder::where("order_id",$request->order_id)->first();
        if(empty($orderInfo)){
            return Common::myJson(ErrorCall::$errOrderNotExist, $validator->errors());
        }
        return Common::myJson(ErrorCall::$errSucc, ["order_status" => $orderInfo->order_status]);
    }
}
