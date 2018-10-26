<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/8/30
 * Time: 16:22
 */

namespace App\Http\Controllers;

use App\Jobs\SendSms;
use App\Jobs\SendSmsQue;
use App\Jobs\SendTemplateMsg;
use App\Models\Dealer;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Rules\ValidatePhoneRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SmsManager;
use PhpSms;
use Captcha;

class ApiController extends Controller
{
    public function getCaptcha()
    {
        return Common::myJson(ErrorCall::$errSucc, captcha_src());
    }
//短信发送频率上有什么样的限制？
//
//短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，1条/分钟，5条/小时，10条/天。
//一个手机号码通过阿里云短信服务平台只能收到40条/天。
//（天的计算方式是是当下时间往后推24小时，例如2017年8月24日：11:00发送一条验证码短信，
//计算限流方式是2017年8月23日11:00点到8月24日：11:00点，是否满40条）
//如您是在发送验证码时提示业务限流，建议您根据以上业务调整接口调用时间
//短信通知： 使用同一个签名和同一个短信模板ID，对同一个手机号码发送短信通知，
//支持50条/日（天的计算方式是是当下时间往后推24小时，
//例如2017年8月24日：11:00发送一条短信，
//计算限流方式是2017年8月23日11:00点到8月24日：11:00点，是否满50条）。
//如您是在发送验证码时提示业务限流，建议您根据以上业务调整接口调用时间

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_phone' => ['sometimes', new ValidatePhoneRule],
            'captcha' => 'required|captcha',
//            'is_need_phone' => 'required|in:0,1'
//            'ckey' => 'required',
//            'captcha' => 'required|captcha:'.$request->ckey
//            'user_password' => 'sometimes|string|max:20|min:6'
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        if (!isset($request->user_phone))  {
            $wxUser = session('wechat.oauth_user');
            $userInfo = User::where("openid",$wxUser['default']->id)->first();
            if (!empty($userInfo->phone)) {
                $request->merge(['user_phone' => $userInfo->phone]);
            }
        }else{
            if(!Common::isPhone($request->user_phone)) {
                return Common::myJson(ErrorCall::$errParams, $validator->errors());
            }
        }
        if (empty($request->user_phone)) {
            Log::info("xxx3");
            return Common::myJson(ErrorCall::$errParams);
        }
        $canSend = SmsManager::validateSendable();
        if (!$canSend) {
            return Common::myJson(ErrorCall::$errCallSendInvalid);
        }
        PhpSms::queue(true);
//        dispatch(new SendSmsQue());
//        dispatch(new SendSms(PhpSms::make("Aliyun","SMS_143560259")->to("15701160070")->data(["code" => "222"])));
        SmsManager::requestVerifySms();
        return Common::myJson(ErrorCall::$errSucc);
    }

    public function sendMessageTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_phone' => ['sometimes', new ValidatePhoneRule],//,"exists:users,phone"
            'captcha' => 'required|captcha',
            'is_need_phone' => 'required|in:0,1'
//            'ckey' => 'required',
//            'captcha' => 'required|captcha:'.$request->ckey
//            'user_password' => 'sometimes|string|max:20|min:6'
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        if ($request->is_need_phone == 0) {
            unset($request->user_phone);
            $userInfo = User::find(60);
            if (!empty($userInfo->phone)) {
                $request->merge(['user_phone' => $userInfo->phone]);
            }
        }
        if (empty($request->user_phone)) {
            return Common::myJson(ErrorCall::$errParams);
        }
        $canSend = SmsManager::validateSendable();
        if (!$canSend) {
            return Common::myJson(ErrorCall::$errCallSendInvalid);
        }
//        dd(session()->all(),$request->input(),$request->all());
        PhpSms::queue(true);
//        dispatch(new SendSmsQue());
//        dispatch(new SendSms(PhpSms::make("Aliyun","SMS_143560259")->to("15701160070")->data(["code" => "222"])));
        SmsManager::requestVerifySms();
        return Common::myJson(ErrorCall::$errSucc);
    }

    public function testredis()
    {
//        Redis::set('name', 'guw+enjie');
        $values = Redis::get('name');
        dd($values);
        //输出："guwenjie"
        //加一个小例子比如网站首页某个人员或者某条新闻日访问量特别高，可以存储进redis，减轻内存压力
        $userinfo = User::find(1);
        Redis::set('user_key', $userinfo);
        if (Redis::exists('user_key')) {
            $values = Redis::get('user_key');
        } else {
            $values = Member::find(1200);//此处为了测试你可以将id=1200改为另一个id
        }
        dump($values);
    }

    public function test()
    {
//        $userInfo->openid, "jDcmC6spBaUxKVHtnoVtJxRjb9dZEAAw13R2yokl5No", [
//        "first" => "您好，充电已开始",
//        "keyword1" => $orderInfo["created_at"],
//        "keyword2" => $deviceInfo->province . $deviceInfo->city . $deviceInfo->area . $deviceInfo->street . $deviceInfo->address,
//        "keyword3" => Common::getPrexZero($request->equipment_id) . ",第" . intval($request->port) . "号插座",
//        "keyword4" => date("Y年m月d日 H:i"),
//        "keyword5" => $deviceInfo->charging_unit_second,
//        "remark" => "欢迎使用智能充电设备，当前余额" . $userInfo->user_money,
//    ]
        $user = User::find(1);
//        $app = app('wechat.official_account');
//        $app->template_message->send([
//            'touser' => $user->openid,
//            'template_id' => 'jDcmC6spBaUxKVHtnoVtJxRjb9dZEAAw13R2yokl5No',
//            'url' => 'https://easywechat.org',
//            'data' => [
//                "first" => "您好，充电已开始",
//                "keyword1" => date("Y-m-d H:i:s"),
//                "keyword2" => "成都市华阳",
//                "keyword3" => "5号机器,第5号插座",
//                "keyword4" => date("Y年m月d日 H:i"),
//                "keyword5" => 123,
//                "remark" => "欢迎使用智能充电设备，当前余额12.5元",
//            ]
//        ]);
        dispatch(new SendTemplateMsg($user->openid,
            "tK-cDfIBNxHi1Iw539U0XM-LL5bH3vCUei_KgkZeZHI", [
                "first" => "您好，充电已开始",
                "keyword1" => date("Y-m-d H:i:s"),
                "keyword2" => "成都市华阳",
                "keyword3" => "5号机器,第5号插座",
                "keyword4" => date("Y年m月d日 H:i"),
                "keyword5" => 123,
                "remark" => "欢迎使用智能充电设备，当前余额12.5元",
            ]));//充电结束
        echo "ok！2!33!";
    }

    public function deleteDeaer(Request $request)
    {
        try{
            $userInfo = User::where("user_id", $request->user_id)->first();
            if(empty($userInfo)){
                exit("用户信息为空") ;
            }
            $userInfo->user_type = 0;//恢复user_type
            $userInfo->save();
            if(!empty($userInfo->dealer)){
                $userInfo->dealer->delete();
            }
            echo "ok";
        }catch (\Exception $e){
            exit($e->getMessage());
        }
    }
}