<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */

namespace App\Http\Controllers;

use App\Models\CashLog;
use App\Models\ChargingEquipment;
use App\Models\Dealer;
use App\Models\ElectricCard;
use App\Models\EquipmentPort;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Eletric;
use App\Models\Logic\ErrorCall;
use App\Models\Logic\Snowflake;
use App\Models\RechargeOrder;
use App\Models\Tixian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use SmsManager;

class DealerController extends Controller
{
    public function center()
    {
        $wxUser = session('wechat.oauth_user');
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();

        $deviceList = ChargingEquipment::where("openid", $dealerInfo->openid)->pluck("equipment_id");
        $dayIncome = 0;
        $totalUsers = 0;
        $totalChargeCount = 0;
        if (!empty($deviceList)) {
            $dayIncome = RechargeOrder::whereIn("equipment_id", $deviceList->toArray())->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_END)->where("created_at", ">",
                date("Y-m-d 00:00:00"))->sum("recharge_price");
            $totalUsers = RechargeOrder::whereIn("equipment_id", $deviceList->toArray())->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_END)->distinct("recharge_str")->count("recharge_str");
            $totalChargeCount = RechargeOrder::whereIn("equipment_id", $deviceList->toArray())->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_END)->count();
        }
        return view('dealer/center', [
            "day_income" => $dayIncome / 100.00,
            "total_income" => $dealerInfo->total_income / 100.00,
            "total_users" => $totalUsers,
            "total_charge_count" => $totalChargeCount,
            "type" => $dealerInfo->user->user_type,
        ]);
    }

//    public function cardManage(Request $request)
//    {
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
//        return view('dealer/cardManage');
//    }

    public function powerStationManage()
    {
        $wxUser = session('wechat.oauth_user');
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        return view('dealer/powerStationManage', [
            "type" => $dealerInfo->user->user_type,
        ]);
    }

    public function dealerManage()
    {
        $wxUser = session('wechat.oauth_user');
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        return view('dealer/dealerManage', ["type" => $dealerInfo->user->user_type]);
    }

    public function dealerDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int|exists:dealers',
        ]);
        if ($validator->fails()) {
            return redirect('/prompt')->with([
                'message' => ErrorCall::$errParams["errmsg"],
                'url' => '/dealer/center',
                'jumpTime' => 3,
                'status' => 'error'
            ]);
        }
        $dealerInfo = Dealer::find($request->id);
        $userInfo = $dealerInfo->user;
        return view('dealer/dealerDetail', ["dealer_info" => $dealerInfo, "type" => $userInfo->user_type]);
    }

    public function incomeAndExpense()
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        $cashLogList = $userInfo->cashLogs;
        return view('dealer/incomeAndExpense', ['cash_log' => $cashLogList, "type" => $userInfo->user_type]);
    }

    public function moneyManage()
    {
        $wxUser = session('wechat.oauth_user');
        $dealInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        $deviceList = ChargingEquipment::where("openid", $dealInfo->openid)->pluck("equipment_id");
        $totalIncome = $dealInfo->total_income;
        $totalUsers = 0;
        $totalChargeCount = 0;
        if (!empty($deviceList)) {
            $totalUsers = RechargeOrder::whereIn("equipment_id", $deviceList->toArray())->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_END)->distinct("recharge_str")->count("recharge_str");
            $totalChargeCount = RechargeOrder::whereIn("equipment_id", $deviceList->toArray())->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_END)->count();
        }
        return view('dealer/moneyManage', [
            "income_withdraw" => ($dealInfo->total_income - $dealInfo->income_withdraw) / 100.00,
            "total_charge_count" => $totalChargeCount,
            "total_income" => $totalIncome / 100.00,
            "total_users" => $totalUsers,
            "type" => $dealInfo->user->user_type,
        ]);
    }

    public function powerStationDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devid' => 'required|string|max:20|min:10',
        ]);
        if ($validator->fails()) {
            return redirect('/prompt')->with([
                'message' => ErrorCall::$errParams["errmsg"],
                'url' => '/dealer/center',
                'jumpTime' => 3,
                'status' => 'error'
            ]);
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_JXS) {
            $deviceInfo = ChargingEquipment::where("equipment_id", $request->devid)->where("openid",
                $userInfo->openid)->first();
        } elseif ($userInfo->user_type == Common::USER_TYPE_SJXS) {
            $userOpenidList = Dealer::where("parent_openid", $userInfo->openid)->pluck("openid");
            $deviceInfo = ChargingEquipment::where("equipment_id", $request->devid)->whereIn("openid",
                $userOpenidList)->first();
        } else {
            $deviceInfo = ChargingEquipment::where("equipment_id", $request->devid)->first();
        }
        if(empty($deviceInfo)) {
            dd("无权限查看");
        }
        $deviceInfo->charging_cost = $deviceInfo->charging_cost * 1.0 / 100;
        $deviceInfo->charging_unit_second = $deviceInfo->charging_unit_second / 60;
        return view('dealer/powerStationDetail',
            [
                "device_info" => $deviceInfo,
                "is_self" => ($deviceInfo->openid == $userInfo->openid),
                "type" => $userInfo->user_type,
            ]);
    }

    public function resetPassword()
    {
        $wxUser = session('wechat.oauth_user');
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        return view('dealer/resetPassword', ["type" => $dealerInfo->user->type]);
    }

    public function bindBank()
    {
        $wxUser = session('wechat.oauth_user');
        $dealer = Dealer::where("openid", $wxUser['default']->id)->first();
        return view('dealer/bindBank', [
            'is_bind_bank' => !empty($dealer->bank_no),
            'bank_no' => $dealer->bank_no,
            'bank_name' => $dealer->bank_name,
            'bank_username' => $dealer->bank_username,
            "type" => $dealer->type
        ]);
    }

    public function revenueSummary()
    {
        $wxUser = session('wechat.oauth_user');
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        $deviceList = ChargingEquipment::where("openid", $dealerInfo->openid)->pluck("equipment_id");
        $totalUsers = 0;
        $totalChargeCount = 0;
        if (!empty($deviceList)) {
            $totalUsers = RechargeOrder::whereIn("equipment_id", $deviceList->toArray())->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_END)->distinct("recharge_str")->count("recharge_str");
            $totalChargeCount = RechargeOrder::whereIn("equipment_id", $deviceList->toArray())->where("recharge_status",
                Charge::ORDER_RECHARGE_STATUS_END)->count();
        }
        return view('dealer/revenueSummary', [
            "total_charge_count" => $totalChargeCount,
            "total_income" => $dealerInfo->total_income / 100.00,
            "total_users" => $totalUsers,
            "type" => $dealerInfo->user->user_type,
        ]);
    }

    public function takeOutMoney()
    {
        $wxUser = session('wechat.oauth_user');
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        return view('dealer/takeOutMoney', [
            "income_withdraw" => ($dealerInfo->total_income - $dealerInfo->income_withdraw) / 100.00,
            "is_set_password" => !empty($dealerInfo->password),
            "is_bind_phone" => !empty($dealerInfo->user->phone),
            "is_bind_bank" => !empty($dealerInfo->bank_no),
            "type" => $dealerInfo->user->user_type,
        ]);
    }

    //修改电卡状态
//    public function changeCardStatus(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'card_id' => "required|exists:electric_cards"
//        ]);
//        if ($validator->fails()) {
//            return Common::myJson(ErrorCall::$errParams, $validator->errors());
//        }
//        $dealerInfo = session(Common::SESSION_KEY_DEALER);
//        $cardInfo = ElectricCard::where("card_id", $request->card_id)->first();
//        if (empty($cardInfo)) {
//            return Common::myJson(ErrorCall::$errCardNotExist);
//        }
//
//        return Common::myJson(ErrorCall::$errSucc);
//    }

    public function getCardInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => "sometimes|exists:electric_cards",
            'bind_phone' => "sometimes|exists:electric_cards",
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        if (!empty($request->card_id)) {
            $cardInfo = ElectricCard::where("card_id", $request->card_id)->first();
        } elseif (!empty($request->bind_phone)) {
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
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_ADMIN) {
            $equipmentInfoList = ChargingEquipment::where("equipment_id", $request->equipment_id)->get();
        } else {
            $equipmentInfoList = ChargingEquipment::where("equipment_id", $request->equipment_id)->where("openid",
                $userInfo->openid)->orWhere("parent_openid", $userInfo->openid)->get();
        }
        foreach ($equipmentInfoList as $equipmentInfo) {
            $jackInfo = json_decode($equipmentInfo->board_info, true);
            $equipmentInfo->total_port = 0;
            for ($i = 1; $i <= 3; $i++) {
                if ($jackInfo["board{$i}"] == 'Y') {
                    $equipmentInfo->total_port += 10;
                }
            }
            $equipmentInfo->use_port_num = EquipmentPort::where("equipment_id",
                $equipmentInfo->equipment_id)->where("status", Eletric::PORT_STATUS_USE)->count();
        }
        return Common::myJson(ErrorCall::$errSucc, $equipmentInfoList);
    }

    public function getEquipmentInfoList(Request $request)
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_ADMIN) {
            $equipmentInfoList = ChargingEquipment::all();
        } else {
            $equipmentInfoList = ChargingEquipment::where("openid", $userInfo->openid)->orWhere("openid",
                $userInfo->dealer->openid)->get();
        }
        foreach ($equipmentInfoList as $equipmentInfo) {
            $jackInfo = json_decode($equipmentInfo->board_info, true);
            $equipmentInfo->total_port = 0;
            for ($i = 1; $i <= 3; $i++) {
                if ($jackInfo["board{$i}"] == 'Y') {
                    $equipmentInfo->total_port += 10;
                }
            }
            $equipmentInfo->use_port_num = EquipmentPort::where("equipment_id",
                $equipmentInfo->equipment_id)->where("status", Eletric::PORT_STATUS_USE)->count();
        }
        return Common::myJson(ErrorCall::$errSucc, $equipmentInfoList);
    }

    public function getDealerInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => "sometimes|string|max:20",
            'user_id' => "sometimes|string|max:16",
            'name' => "sometimes|string|max:16",
        ]);
        if ($validator->fails() || (empty($request->phone) && empty($request->user_id) && empty($request->name))) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_NORMAL || $userInfo->user_type == Common::USER_TYPE_JXS) {
            return Common::myJson(ErrorCall::$errNotPermit);
        }
        $searchUser = null;
        $nameFlag = false;
        if (!empty($request->phone)) {
            $searchUser = User::where("phone", $request->phone)->get();
        } elseif (!empty($request->user_id)) {
            $searchUser = User::where("user_id", $request->user_id)->get();
        } elseif (!empty($request->name)) {
            $nameFlag = true;
            $searchUser = Dealer::where("name", 'like', $request->name)->get();
        }
        if (empty($searchUser)) {
            return Common::myJson(ErrorCall::$notFindUser);
        }
        if ($userInfo->user_type == Common::USER_TYPE_ADMIN) {
            $dealerList = null;
            foreach ($searchUser as $user) {
                if($nameFlag) {
                    $dealerInfo = $user;
                    $dealerInfo->phone = $dealerInfo->user->phone;
                    $dealerInfo->user_status = $dealerInfo->user->user_status;
                    unset($dealerInfo->user);
                }else{
                    $dealerInfo = $user->dealer;
                    $dealerInfo->phone = $user->phone;
                    $dealerInfo->user_status = $user->user_status;
                }
                $dealerList[] = $dealerInfo;
            }
            return Common::myJson(ErrorCall::$errSucc, $dealerList);
        } else {//超级经销商
            $dealerList = null;
            foreach ($searchUser as $user) {
                if($nameFlag && $user->parent_openid == $userInfo->openid) {
                    $dealerInfo = $user;
                    $dealerInfo->phone = $dealerInfo->user->phone;
                    $dealerInfo->user_status = $dealerInfo->user->user_status;
                    unset($dealerInfo->user);
                }else{
                    $dealerInfo = $user->dealer()->where("parent_openid", $userInfo->openid)->first();
                    $dealerInfo->phone = $user->phone;
                    $dealerInfo->user_status = $user->user_status;
                }
                if (!empty($dealerInfo)) {
                    $dealerList[] = $dealerInfo;
                }
            }
            return Common::myJson(ErrorCall::$errSucc, $dealerList);
        }
    }

    public function getDealerList(Request $request)
    {
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_NORMAL || $userInfo->user_type == Common::USER_TYPE_JXS) {
            return Common::myJson(ErrorCall::$errNotPermit);
        }
        $dealerInfo = $userInfo->dealer;

        if ($userInfo->user_type == Common::USER_TYPE_ADMIN) {
            $dealerList = null;
            $searchUser = Dealer::all();
            foreach ($searchUser as $dealer) {
                $user = $dealer->user;
                $dealerList[] = $dealer;
            }
            return Common::myJson(ErrorCall::$errSucc, $dealerList);
        } else {//超级经销商
            $searchUser = Dealer::where("parent_openid", $dealerInfo->openid)->get();
            $dealerList = null;
            foreach ($searchUser as $dealer) {
                $user = $dealer->user;
                $dealerList[] = $dealer;
            }
            return Common::myJson(ErrorCall::$errSucc, $dealerList);
        }
    }

    public function getRevenueSummaryList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => "required|in:1,2",
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        $sumPrice = 0;
        if ($request->type == Common::SHOW_HUIZONG_TYPE_JXS) {
            //来自其他经销商的收益，直属下级
            $childOpneids = Dealer::where("parent_openid", $userInfo->openid)->pluck("openid");
            $cashLog = CashLog::whereIn("openid", $childOpneids)
                ->where("cash_type", Common::CASH_TYPE_SHARE)
                ->where("cash_status", Common::CASH_STATUS_INCOME)
                ->select(DB::raw('sum(cash_price) as sum_cash_price'), 'openid')
                ->groupBy("openid")->get();
            foreach ($cashLog as $cash) {
                $sumPrice += $cash->sum_cash_price;
                $cash->sum_cash_price = $cash->sum_cash_price / 100.00;
                $cash->id_card = $cash->dealer->id_card;
                $cash->address = $cash->dealer->province . $cash->dealer->city . $cash->dealer->area;
                $cash->name = $cash->dealer->name;
                $cash->phone = $cash->user->phone;
                $cash->user_status = $cash->user->user_status;
                unset($cash->user);
                unset($cash->dealer);
            }
        } else {
            //来自普通用户的收益，直属下级
            $equipmentIds = ChargingEquipment::where("openid", $userInfo->openid)->pluck("equipment_id");
            $cashLog = CashLog::whereIn("equipment_id", $equipmentIds)
                ->where("cash_type", Common::CASH_TYPE_DEVIC)
                ->where("cash_status", Common::CASH_STATUS_INCOME)
                ->select(DB::raw('sum(cash_price) as sum_cash_price'), 'equipment_id')
                ->groupBy("equipment_id")->get();
            foreach ($cashLog as $cash) {
                $sumPrice += $cash->sum_cash_price;
                $cash->sum_cash_price = $cash->sum_cash_price / 100.00;
                $cash->address = $cash->chargingEquipment->address;
                $cash->equipment_id = $cash->chargingEquipment->equipment_id;
                $cash->name = $cash->chargingEquipment->province . $cash->chargingEquipment->city . $cash->chargingEquipment->area;
                $cash->equipment_status = $cash->chargingEquipment->equipment_status;
                unset($cash->chargingEquipment);
            }
        }
        return Common::myJson(ErrorCall::$errSucc, ["revenue_summary_list" => $cashLog, "sum_price" => $sumPrice / 100.00]);
    }

    public function doAddDealer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|string|max:10|min:2",
            'id_card' => "required|string|max:20|min:18",
            "province" => "required|string",
            "city" => "required|string",
            "area" => "required|string",
            "give_proportion" => "required|int|max:99|min:1",
            "son_id" => "required|string|max:16|min:10",
            "remark" => "sometimes|string|max:225",
            "user_type" => "required|int|in:1,2", //1,普通经销商，2，超级经销商
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_JXS || ($userInfo->user_type == Common::USER_TYPE_SJXS && $request->user_type == Common::USER_TYPE_SJXS)) {
            return Common::myJson(ErrorCall::$errNotPermit, $validator->errors());
        }

        $addUser = User::where("user_id", $request->son_id)->where("user_status",
            Common::USER_STATUS_DEFAULT)->where("user_type",
            Common::USER_TYPE_NORMAL)->first();
        if (empty($addUser)) {
            return Common::myJson(ErrorCall::$notFindUser);
        }
        Dealer::create([
            "openid" => $addUser->openid,
            "id_card" => $request->id_card,
            "province" => $request->province,
            "city" => $request->city,
            "area" => $request->area,
            "give_proportion" => $request->give_proportion,
            "name" => $request->name,
            "remark" => $request->remark,
            "parent_openid" => $userInfo->openid,
        ]);
        $addUser->user_type = $request->user_type == 1 ? Common::USER_TYPE_JXS : Common::USER_TYPE_SJXS;
        $res = $addUser->save();
        if (!$res) {
            return Common::myJson(ErrorCall::$errSys);
        }
        return Common::myJson(ErrorCall::$errSucc);
    }

    public function doUpdateDealer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => "required|string|exists:users",
            'name' => "required|string|max:10|min:2",
            'id_card' => "required|string|max:20|min:18",
            "province" => "required|string",
            "city" => "required|string",
            "area" => "required|string",
            "give_proportion" => "required|int|max:100|min:1",
            "remark" => "sometimes|string|max:225",
            "user_status" => "required|int|in:0,1",
            //            'verifyCode' => 'sometimes|verify_code',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        $updateUserInfo = User::where("user_id", $request->user_id)->first();
        if ($userInfo->user_type == Common::USER_TYPE_JXS) {
            return Common::myJson(ErrorCall::$errNotPermit, $validator->errors());
        }
        if ($userInfo->openid != $updateUserInfo->dealer->parent_openid && $userInfo->user_type == Common::USER_TYPE_SJXS) {
            return Common::myJson(ErrorCall::$errNotPermit, $validator->errors());
        }
        try {
            DB::transaction(function () use ($updateUserInfo, $request) {
                $updateUserInfo->user_status = $request->user_status;
                $updateUserInfo->save();
                $dealerInfo = $updateUserInfo->dealer;
                $dealerInfo->name = $request->name;
                $dealerInfo->id_card = $request->id_card;
                $dealerInfo->province = $request->province;
                $dealerInfo->city = $request->city;
                $dealerInfo->area = $request->area;
                $dealerInfo->give_proportion = $request->give_proportion;
                $dealerInfo->remark = $request->remark;
                $dealerInfo->save();
            });
        } catch (\Exception $e) {
            Log::debug(__FUNCTION__ . ":" . serialize($e->getMessage()));
            return Common::myJson(ErrorCall::$errSys);
        }
        return Common::myJson(ErrorCall::$errSucc);
    }

    public function doResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed'],//不为空,两次密码是否相同
            'password_confirmation' => ['required', "same:password"],//不为空,两次密码是否相同
            'id_card' => 'required',
            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $dealer = Dealer::where("openid", $wxUser['default']->id)->first();
        if ($dealer->id_card != $request->id_card) {
            return Common::myJson(ErrorCall::$errIdcard, $validator->errors());
        }
        $dealer->password = md5($request->password);
        $res = $dealer->save();
        if ($res) {
            session([Common::SESSION_KEY_DEALER => $dealer]);
            return Common::myJson(ErrorCall::$errSucc);
        } else {
            return Common::myJson(ErrorCall::$errNet);
        }
    }

    public function doSetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed'],//不为空,两次密码是否相同
            'password_confirmation' => ['required', "same:password"],//不为空,两次密码是否相同
//            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $dealer = Dealer::where("openid", $wxUser['default']->id)->first();
        if ($dealer->password != "") {
            return Common::myJson(ErrorCall::$errPassword, $validator->errors());
        }
        $dealer->password = md5($request->password);
        $res = $dealer->save();
        if ($res) {
            return Common::myJson(ErrorCall::$errSucc);
        } else {
            return Common::myJson(ErrorCall::$errNet);
        }
    }

    public function doUpdateEquipment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "province" => "required|string|max:16",
            "city" => "required|string|max:16",
            "area" => "required|string|max:255",
            "street" => "required|string|max:255",
            "address" => "required|string|max:255",
            "charging_cost" => "required",
            "charging_unit_min" => "required|int",
//            'verifyCode' => 'sometimes|verify_code',
            'equipment_id' => 'required|string|max:20|min:10|exists:charging_equipments',
            'equipment_status' => 'required|int:1,2',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $equipmentInfo = ChargingEquipment::where("equipment_id", $request->equipment_id)->first();
        if (empty($equipmentInfo) || $equipmentInfo->equipment_status == $request->equipment_status) {
            return Common::myJson(ErrorCall::$errEquipmentStatus);
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_status != Common::USER_STATUS_DEFAULT || $userInfo->user_type == Common::USER_TYPE_NORMAL) {
            return Common::myJson(ErrorCall::$errNotPermit, $validator->errors());
        }

        $updateParams = [
            "province" => $request->province,
            "city" => $request->city,
            "area" => $request->area,
            "street" => $request->street,
            "address" => $request->address,
            "openid" => $userInfo->openid,
            "equipment_status" => $request->equipment_status,
        ];
        if ($userInfo->openid == $equipmentInfo->openid) {
            $updateParams["charging_cost"] = $request->charging_cost * 100;
            $updateParams["charging_unit_second"] = $request->charging_unit_min * 60;
        }
        if ($request->equipment_status == Eletric::DEVICE_STATUS_ACTIVE) {
            $updateParams["active_time"] = date("Y-m-d H:i:s");
        }
        $res = $equipmentInfo->update($updateParams);
        if ($res) {
            return Common::myJson(ErrorCall::$errSucc);
        } else {
            return Common::myJson(ErrorCall::$errNet);
        }
    }

    public function doTixian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "money" => "required|int",
            "password" => "required|string|max:16",
            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $userInfo = User::where("openid", $wxUser['default']->id)->first();
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        if ($userInfo->user_status != Common::USER_STATUS_DEFAULT || $userInfo->user_type == Common::USER_TYPE_NORMAL) {
            return Common::myJson(ErrorCall::$errNotPermit, $validator->errors());
        }
        if ($dealerInfo->password != md5($request->password)) {
            return Common::myJson(ErrorCall::$errPassword, $validator->errors());
        }
        if ($request->money * 100 > $dealerInfo->total_income - $dealerInfo->income_withdraw) {
            return Common::myJson(ErrorCall::$errNotEnough, $validator->errors());
        }

        try {
            DB::transaction(function () use ($dealerInfo, $request) {
                $dealerInfo->income_withdraw = $dealerInfo->income_withdraw + $request->money * 100;
                $dealerInfo->save();
                Tixian::create([
                    "openid" => $dealerInfo->openid,
                    "money" => $request->money * 100,
                ]);
                CashLog::create([
                    "openid" => $dealerInfo->openid,
                    "equipment_id" => "",
                    "cash_id" => Snowflake::nextId(),
                    "cash_type" => Common::CASH_TYPE_TIXIAN,
                    "cash_status" => Common::CASH_STATUS_OUT,
                    "cash_price" => $request->money * 100,
                ]);
            });
        } catch (\Exception $e) {
            Log::debug(__FUNCTION__ . ":" . serialize($e->getMessage()));
            return Common::myJson(ErrorCall::$errSys);
        }
        return Common::myJson(ErrorCall::$errSucc);
    }

    public function getCashLogList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "cash_status" => "sometimes|int",
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        if(isset($request->cash_status)) {
            $cashLogList = CashLog::where("openid", $wxUser['default']->id)->where("cash_status", $request->cash_status)->get();
        }else{
            $cashLogList = CashLog::where("openid", $wxUser['default']->id)->get();
        }
        foreach ($cashLogList as &$cashlog) {
            $cashlog->cash_price = sprintf("%.2f",$cashlog->cash_price * 1.00 / 100);
        }
        return Common::myJson(ErrorCall::$errSucc, ["cash_log_list" => $cashLogList]);
    }

    public function doBindBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bank_name" => "required|string",
            "bank_no" => "required|string",
            "bank_username" => "required|string",
//            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $wxUser = session('wechat.oauth_user');
        $dealerInfo = Dealer::where("openid", $wxUser['default']->id)->first();
        $dealerInfo->bank_name = $request->bank_name;
        $dealerInfo->bank_no = $request->bank_no;
        $dealerInfo->bank_username = $request->bank_username;
        $res = $dealerInfo->save();
        if (!$res) {
            return Common::myJson(ErrorCall::$errSys);
        } else {
            return Common::myJson(ErrorCall::$errSucc);
        }
    }
}