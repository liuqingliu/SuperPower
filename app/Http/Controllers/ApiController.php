<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/8/30
 * Time: 16:22
 */
namespace App\Http\Controllers;

use App\Models\Logic\Common;
use App\Models\Logic\ErrorCall;
use App\Rules\ValidatePhoneRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SmsManager;
use PhpSms;


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
        //开启队列:
//        $res = PhpSms::make("Aliyun","SMS_143560259")->to("16602821326")->data(["code" => "12134"])->send();
//        dd($res);
//        PhpSms::queue(true);

        $validator = Validator::make($request->all(), [
            'user_phone' => ['required',new ValidatePhoneRule],//,"exists:users,phone"
//            'user_password' => 'sometimes|string|max:20|min:6'
        ]);
        if ($validator->fails()) {
            return Common::myJson(ErrorCall::$errParams, $validator->errors());
        }
        $canSend = SmsManager::validateSendable();
        if(!$canSend){
            return Common::myJson(ErrorCall::$errCallSendInvalid);
        }

        $sendResult = SmsManager::requestVerifySms();

        if (!$sendResult["success"]) {
            return Common::myJson(ErrorCall::$errSendFail);
        }
        return Common::myJson(ErrorCall::$errSucc);
    }
}