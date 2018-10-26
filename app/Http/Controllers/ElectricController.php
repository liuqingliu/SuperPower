<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */

namespace App\Http\Controllers;

use App\Jobs\CalculateIncome;
use App\Jobs\SendTemplateMsg;
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
    public function cardorderpay(Request $request)
    {
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        $cardInfo = ElectricCard::where("card_id", $request->card_id)->first();
        $app = app('wechat.official_account');
        $wxJssdkconfig = $app->jssdk->buildConfig(array('checkJsApi', 'scanQRCode'), false);
        return view('electric/cardorderpay', [
            "pay_money_list" => $payMoneyList,
            "pay_method_list" => $payMethodList,
            "card_id" => $request->card_id,
            "money" => isset($cardInfo->money) ? ($cardInfo->money * 1.0 / 100.00) : "",
            "wxjssdk" => $wxJssdkconfig,
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
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        $rechargeInfo = RechargeOrder::where("recharge_str", $userInfo->openid)->where("recharge_status", Charge::ORDER_RECHARGE_STATUS_CHARGING)->first();
        if(empty($rechargeInfo)) {//这里其实需要跳转走
            return redirect('/prompt')->with([
                'message' => "没有正在充电的订单",
                'url' => '/user/center',
                'jumpTime' => 3,
                'status' => 'error'
            ]);
        }
        $chargingEquipment = $rechargeInfo->chargingEquipment;
        $unitSecond = $chargingEquipment->charging_unit_second;
        $nowTime = time();
        return view('electric/recharge', [
            "unit_hour" => $unitSecond / 60,
//            "created_at" => $rechargeInfo->created_at,
            "socket_info" => $chargingEquipment->address . $rechargeInfo->jack_id . "号插座",
            "charge_time" => ceil(($nowTime-strtotime($rechargeInfo->created_at))/60),
//            "now_time" => date("Y-m-d H:i:s",$nowTime),
        ]);
    }

    public function choosesocket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devid' => 'required|string|max:20|min:10',
        ]);
        if ($validator->fails()) {
            return redirect('/prompt')->with([
                'message' => ErrorCall::$errParams["errmsg"],
                'url' => '/user/center',
                'jumpTime' => 3,
                'status' => 'error'
            ]);
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        $rechargeOrder = RechargeOrder::where("recharge_str", $userInfo->openid)->where("recharge_status",
            Charge::ORDER_RECHARGE_STATUS_CHARGING)->first();
        if (!empty($rechargeOrder)) {
            return redirect('/electric/recharge');
        }
        //获取当前终端的基本信息
        $device = ChargingEquipment::where("equipment_id", $request->devid)->first();
        $portInfo = EquipmentPort::where("equipment_id", $request->devid)->get();
        $boardInfo = json_decode($device->board_info, true);
        $cnt = 0;
        $portInfoRes = [];
        foreach ($portInfo as $key => $port) {
            $cnt++;
            if ($boardInfo["board1"] == "Y" && $cnt <= 10) {
                $portInfoRes[$port->port] = $port->status;
            }
            if ($boardInfo["board2"] == "Y" && $cnt < 10 && $cnt <= 20) {
                $portInfoRes[$port->port] = $port->status;
            }
            if ($boardInfo["board3"] == "Y" && $cnt < 20 && $cnt <= 30) {
                $portInfoRes[$port->port] = $port->status;
            }
        }

        return view('electric/choosesocket', [
            "device_info" => Common::getNeedObj([
                "equipment_status",
                "net_status",
                "equipment_id",
                "province",
                "city",
                "area",
                "street",
                "address",
                "manager_phone",
                "charging_unit_second",
                "jack_info",
                "board_info",//存储board1
            ], $device),
            "charge_type_list" => Charge::$chargeTypeList,
            "portInfo" => $portInfoRes,
            "user_money" => $userInfo->user_money,
        ]);
    }

    public function rechargelog()
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        $rechareList = RechargeOrder::where("recharge_str", $userInfo->openid)->where("recharge_status",Charge::ORDER_RECHARGE_STATUS_END)->get();
        $res = [];
        foreach ($rechareList as $recharge) {
            $tmp = [];
            $device = $recharge->chargingEquipment;
            $tmp["device_address"] = $device->address;
            $tmp["recharge_end_time"] = $recharge->recharge_end_time;
            $tmp["recharge_price"] = $recharge->recharge_price;
            $tmp["date"] = date("Y-m-d", strtotime($recharge->created_at));
            $tmp["time_s"] = date("H:i", strtotime($recharge->created_at));
            $tmp["time_e"] = date("H:i", strtotime($recharge->recharge_end_time));
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
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
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
            "price" => 1,
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
            'total_fee' => 1,
            'trade_type' => 'JSAPI',
            'openid' => $userInfo->openid,
            "card_id" => $request->card_id,
            'notify_url' => 'https://'.Common::DOMAIN.'/payment/wechatnotify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
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
            'port' => 'required|int|max:30|min:1',
            'recharge_type' => 'required|int|in:' . implode(",", array_keys(Charge::$chargeTypeList)),
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $deviceInfo = ChargingEquipment::where("equipment_id", $request->equipment_id)->first();
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        if ($userInfo->user_money < 200 || $userInfo->user_money < floor(Charge::$chargeTypeList[$request->recharge_type] / $deviceInfo->charging_unit_second) * 100) {
            return Common::myJson(ErrorCall::$errUserMoneyNotEnough);
        }
        DB::beginTransaction();
        try{
            $portInfo = EquipmentPort::where("equipment_id", $request->equipment_id)->where("port",
                $request->port)->lockForUpdate()->first();
            if (empty($portInfo)) {
                DB::rollback();
                return Common::myJson(ErrorCall::$errPortInvalid);
            }
            if ($portInfo->status == Eletric::PORT_STATUS_USE) {
                DB::rollback();
                return Common::myJson(ErrorCall::$errPortUserd);
            }
            //生成订单
            $orderInfo = [
                "order_id" => Snowflake::nextId(),
                "recharge_str" => $userInfo->openid,
                "equipment_id" => $request->equipment_id,
                "port" => $request->port,
                "recharge_total_time" => Charge::$chargeTypeList[$request->recharge_type],
                "recharge_unit_second" => $deviceInfo->charging_unit_second,
                "recharge_price" => ceil(Charge::$chargeTypeList[$request->recharge_type] / $deviceInfo->charging_unit_second) * 100,
                "type" => Charge::ORDER_RECHARGE_TYPE_USER,
                "created_at" => date("Y-m-d H:i:s")
            ];
            RechargeOrder::insert($orderInfo);
            $portInfo->status = Eletric::PORT_STATUS_USE;
            $portInfo->save();
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
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
        dispatch(new SendTemplateMsg($userInfo->openid, "jDcmC6spBaUxKVHtnoVtJxRjb9dZEAAw13R2yokl5No", [
            "first" => "您好，充电已开始",
            "keyword1" => $orderInfo["created_at"],
            "keyword2" => $deviceInfo->province . $deviceInfo->city . $deviceInfo->area . $deviceInfo->street . $deviceInfo->address,
            "keyword3" => Common::getPrexZero($request->equipment_id) . ",第" . intval($request->port) . "号插座",
            "keyword4" => date("Y年m月d日 H:i"),
            "keyword5" => $deviceInfo->charging_unit_second,
            "remark" => "欢迎使用智能充电设备，当前余额" . $userInfo->user_money,
        ]));//充电开始
        return Common::myJson(ErrorCall::$errSucc);
    }

    //关闭插座
    public function closeSocket()
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid",$wxUser['default']->id)->first();
        $rechargeOrder = RechargeOrder::where("recharge_str", $userInfo->openid)->where("recharge_status", Charge::ORDER_RECHARGE_STATUS_CHARGING)->first();
        if (empty($rechargeOrder)) {
            return Common::myJson(ErrorCall::$errOrderNotExist);
        }
        $portInfo = EquipmentPort::where("equipment_id", $rechargeOrder->equipment_id)->where("port",
            $rechargeOrder->port)->first();
        try {
            DB::transaction(function () use ($rechargeOrder, $portInfo) {
                $rechargeOrder->recharge_status = Charge::ORDER_RECHARGE_STATUS_ENDING;
                $rechargeOrder->recharge_end_time = date("Y-m-d H:i:s");
                $rechargeOrder->recharge_price = ceil(time() - strtotime($rechargeOrder->created_at))/($rechargeOrder->recharge_unit_second) ;
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
        dispatch(new SendWulianQue($rechargeOrder->equipment_id, $callArr));//下发3次，直到有回复过来
        dispatch(new SendTemplateMsg($rechargeOrder->recharge_str,
            "tK-cDfIBNxHi1Iw539U0XM-LL5bH3vCUei_KgkZeZHI", [
                "first" => "尊敬的用户，您的充电已经完成！",
                "keyword1" => $rechargeOrder->created_at,
                "keyword2" => $rechargeOrder->recharge_end_time,
                "keyword3" => (strtotime($rechargeOrder->recharge_end_time) - strtotime($rechargeOrder->created_time)) . "秒",
                "keyword4" => ($userInfo->user_money * 1.0 / 100.00) . "元",
                "keyword5" => $rechargeOrder->chargingEquipment->province . $rechargeOrder->chargingEquipment->city . $rechargeOrder->chargingEquipment->area . $rechargeOrder->chargingEquipment->street,
                "remark" => "我们期待与您的下一次邂逅！",
            ]));//充电结束
        dispatch(new CalculateIncome($rechargeOrder->order_id));
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
        $orderInfo = RechargeOrder::where("order_id", $request->order_id)->first();
        if (empty($orderInfo)) {
            return Common::myJson(ErrorCall::$errOrderNotExist, $validator->errors());
        }
        return Common::myJson(ErrorCall::$errSucc, ["order_status" => $orderInfo->order_status]);
    }
}
