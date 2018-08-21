<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;

use App\Models\ElectricCardOrder;
use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Models\Logic\Order;
use App\Models\UserRechargeOrder;
use Illuminate\Http\Request;

class ElectricController extends Controller
{
    public function cardorderpay()
    {
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        return view('electric/cardorderpay',[
            "pay_money_list" => $payMethodList,
            "pay_method_list" => $payMoneyList,
        ]);
    }

    public function cardorderpayanswer()
    {
        $electricCardOrders = ElectricCardOrder::find(1,["order_status"])->toArray();
        return view('electric/cardorderpayanswer',[
            "order_status" => $electricCardOrders["order_status"]
        ]);
    }

    public function recharge()
    {
        $rechargeInfo = UserRechargeOrder::find(1);
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

    public function choosesocket()
    {
        return view('electric/choosesocket');
    }

    public function rechargelog()
    {
        return view('electric/rechargelog');
    }

    public function getRechargeLog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'count' => 'sometimes|int|max:20|min:1',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams);
        }
        $count = isset($request->count) ? (int)$request->count : 10;
        $userId = 1;
        $data = UserRechargeOrder::with("chargingEquipment")->where("user_id", $userId)->orderBy('created_at', 'desc')->paginate($count);
        return Common::myJson(ErrorCall::$errSucc, $data->toArray());
    }

    public function updateChargingOrder(Request $request)
    {
        $userId = 1;
        $chargingOrderInfo = UserRechargeOrder::find($userId);
        if($chargingOrderInfo["user_id"]!=$userId){
            return Common::myJson(ErrorCall::$errNotSelfUser);
        }
        if($chargingOrderInfo["recharge_status"]!=0){
            return Common::myJson(ErrorCall::$errChargingStatus);
        }
        $chargingOrderInfo->recharge_status = 1;//停止充电
        $chargingOrderInfo->recharge_time = time()-strtotime($chargingOrderInfo->created_at);//单位秒
        $res = $chargingOrderInfo->save();
        if(!$res){
            return Common::myJson(ErrorCall::$errNet);
        }
        return Common::myJson(ErrorCall::$errSucc);
    }
}