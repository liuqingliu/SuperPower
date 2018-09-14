<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;

use App\Models\ChargingEquipment;
use App\Models\Dealer;
use App\Models\ElectricCard;
use App\Models\Logic\Common;
use App\Models\Logic\Eletric;
use App\Models\Logic\ErrorCall;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SmsManager;

class DealerController extends Controller
{
    public function center()
    {
//        $totalIncome = Dealer::find(1)->total_income;
//        //今日收益需要实时计算吗？ todo 询问
//        $dayIncome = 122;
//        $totalUsers = 133;
//        $totalChargeCount = 143234;
//        return view('dealer/center',[
//            "day_income" => $dayIncome,
//            "total_income" => $totalIncome,
//            "total_users" => $totalUsers,
//            "total_charge_count" => $totalChargeCount,
//        ]);
        return view('dealer/center');
    }

    public function cardManage(Request $request)
    {
//        //验证数据
//        $validator = Validator::make($request->all(), [
//            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
//            'verifyCode' => 'required|verify_code',
//            //more...
//        ]);
//        if ($validator->fails()) {
//            //验证失败后建议清空存储的发送状态，防止用户重复试错
//            SmsManager::forgetState();
//            dd($validator->errors());
//        }
//        dd(1);
        return view('dealer/cardManage');
    }

    public function powerStationManage()
    {
        return view('dealer/powerStationManage');
    }

    public function dealerManage()
    {
        return view('dealer/dealerManage');
    }

    public function dealerDetail()
    {
        return view('dealer/dealerDetail');
    }

    public function incomeAndExpense()
    {
        return view('dealer/incomeAndExpense');
    }

    public function moneyManage()
    {
        $dealInfo = Dealer::find(1,["income_withdraw","total_income"]);
        $totalUsers = 133;
        $totalChargeCount = 143234;
        return view('dealer/moneymanage',[
            "income_withdraw" => $dealInfo->income_withdraw,
            "total_income" => $dealInfo->total_income,
            "total_users" => $totalUsers,
            "total_charge_count" => $totalChargeCount,
        ]);
    }
    public function powerStationDetail()
    {
        return view('dealer/powerStationDetail');
    }

    public function resetPassword()
    {
        return view('dealer/resetPassword');
    }

    public function revenueSummary()
    {
        return view('dealer/revenueSummary');
    }

    public function takeOutMoney()
    {
        $dealerInfo = Dealer::find(1);
        return view('dealer/takeOutMoney',["income_withdraw" => $dealerInfo->income_withdraw]);
    }

    //修改电卡状态
    public function changeCardStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => "required|exists:electric_cards"
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $cardInfo = ElectricCard::where("card_id", $request->card_id)->first();
        if(empty($cardInfo)){
            return Common::myJson(ErrorCall::$errCardNotExist);
        }

        return Common::myJson(ErrorCall::$errSucc);
    }

    public function getCardInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => "sometimes|exists:electric_cards",
            'bind_phone' => "sometimes|exists:electric_cards",
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        if(!empty($request->card_id)){
            $cardInfo = ElectricCard::where("card_id", $request->card_id)->first();
        }elseif(!empty($request->bind_phone)){
            $cardInfo = ElectricCard::where("bind_phone", $request->bind_phone)->first();
        }
        return Common::myJson(ErrorCall::$errSucc, $cardInfo);
    }

    public function getEquipmentInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equipment_id' => "required|exists:charging_equipments",
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $equipmentInfo = ChargingEquipment::where("equipment_id", $request->equipment_id)->first();
        return Common::myJson(ErrorCall::$errSucc, $equipmentInfo);
    }
}