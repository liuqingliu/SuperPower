<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;
use App\Models\Logic\Order;
use App\Models\User;
use App\Models\UserOrder;
use App\Rules\ValidatePhoneRule;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function center()
    {
        $userInfo = User::find(1, ["nickname","phone","user_id","user_money","user_type"])->toArray();
        return view('user/center',[
            "user_info" =>  $userInfo,
        ]);
    }

    public function detail()
    {
        $userInfo = User::find(1, ["nickname","phone","user_id","user_money","charging_total_cnt","charging_total_time"]);
        return view('user/detail',[
            "user_info" => $userInfo
        ]);
    }

    public function bindphone()
    {
        $userInfo = User::find(1, ["phone"]);
        return view('user/bindphone',[
            "user_info" => $userInfo
        ]);
        return view('center/index');
    }

    public function order()
    {
        $payMoneyList = Order::$payMoneyList;
        $payMethodList = Order::$payMethodList;
        return view('user/order',[
            "pay_money_list" => $payMethodList,
            "pay_method_list" => $payMoneyList,
        ]);
    }

    public function orderanswser()
    {
        $orderInfo = UserOrder::find(1,["order_status"])->toArray();
        return view('user/orderanswser',["pay_status" => $orderInfo["order_status"]]);
    }

    public function about()
    {
        return view('user/about');
    }

    //更新用户手机号
    public function updateUserPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required',new ValidatePhoneRule],
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>1,'msg'=>'更新失败！']);
        }
        $userId = "1";
        $userInfo = User::find($userId);
        $userInfo->phone = $request->phone;
        $res = $userInfo->save();
        return response()->json(['status'=>0,'msg'=>'更新成功！','data'=>$res]);
    }
}