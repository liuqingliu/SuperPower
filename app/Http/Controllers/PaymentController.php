<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/25
 * Time: 14:41
 */

namespace App\Http\Controllers;

use App\Jobs\SendTemplateMsg;
use App\Mail\CommonError;
use App\Models\ElectricCard;
use App\Models\Logic\Charge;
use App\Models\Logic\Common;
use App\Models\Logic\Order;
use App\Models\User;
use App\Models\Order as ChargeOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class PaymentController extends Controller
{
    //微信通知回调
    //注意：请把 “支付成功与否” 与 “是否处理完成” 分开，它俩没有必然关系。
    //比如：微信通知你用户支付完成，但是支付失败了(result_code 为 'FAIL')，
    //你应该更新你的订单为支付失败，但是要告诉微信处理完成。
    public function wechatnotify(Request $request)
    {
        Log::info("payment_notify_request:start111-" . __FUNCTION__ . ",request:" . serialize($request->toArray()));
        $app = app('wechat.payment');
        $response = $app->handlePaidNotify(function ($message, $fail) {
            Log::info("notfiy:message:" . serialize($message));
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = ChargeOrder::where("order_id", $message['out_trade_no'])->where("openid",
                $message["openid"])->first();
            if (empty($order) || $order->order_status == Order::ORDER_STATUS_SUCCESS) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            $app = app('wechat.payment');
            $wxOrder = $app->order->queryByOutTradeNumber($message['out_trade_no']);//
            if ($wxOrder['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($wxOrder, 'result_code') !== 'SUCCESS'
                    || array_get($wxOrder, 'trade_state') !== 'SUCCESS') {
                    return $fail('还没有支付成功哦~');
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            if ($wxOrder["total_fee"] != $order->price) {
                $errmsg = [
                    "adr" => __METHOD__.",".__FUNCTION__,
                    "desc" => "查询到微信订单信息异常,价格不统一",
                    "detail" =>"订单order_id：".$order->order_id. "微信反馈金额：".$wxOrder["total_fee"].",我方金额：".$order->price,
                ];
                Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
            }

            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    $order->order_status = Order::ORDER_STATUS_SUCCESS;
                    $order->pay_id = array_get($message, 'transaction_id');
                    // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    $order->order_status = Order::ORDER_STATUS_FAILED;
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            //记录日志
            //如果保存失败，会出现什么情况？
            $res = $order->save(); // 保存订单
            if ($res) {
                //给用户余额+钱(电卡)
                if($order->order_type==Charge::ORDER_RECHARGE_TYPE_USER) {
                    $user = User::where("openid", $message["openid"])->first();
                    $user->user_money = $user->user_money + $wxOrder["total_fee"];
                    $res2 = $user->save();
                }else{
                    $cardInfo = ElectricCard::where("card_id", $order->card_id)->first();
                    $cardInfo = $cardInfo->money + $wxOrder["total_fee"];
                    $res2 = $cardInfo->save();
                }

            }
            if (!$res || !$res2) {
                $errmsg = [
                    "adr" => __METHOD__.",".__FUNCTION__,
                    "desc" => "微信订单信息异常",
                    "detail" =>"微信通知，入库失败，用户充了钱，但是更新信息失败！！！微信方：".serialize($message)."我方订单id：".$order->order_id.",res={$res}(保存订单为支付成功失败),res2={$res2}（更新用户账户失败）",
                ];
                Mail::to(Common::$emailOferrorForWechcatOrder)->queue(new CommonError($errmsg));
            } else {
                dispatch(new SendTemplateMsg($message["openid"], "oGikchlZLTCLf3aR7ar58DqGywd1nCUBTkDY4WkKO40", [
                    "first" => "您好，账户充值成功",
                    "keyword1" => ($order->price * 1.0 / 100.00) . "元",
                    "keyword2" => $order->created_at,
                    "remark" => "感谢您的使用"
                ]));//充值成功
            }
            return true; // 返回处理完成
        });

        return $response; // Laravel 里请使用：return $response;
    }
}