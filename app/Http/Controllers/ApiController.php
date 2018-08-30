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
use Illuminate\Http\Request;
use SmsManager;

class ApiController extends Controller
{
    public function getCaptcha()
    {
        return Common::myJson(ErrorCall::$errSucc, captcha_src());
    }

    public function sendMessage()
    {
        $canSend = SmsManager::validateSendable();
        $sendResult = SmsManager::requestVerifySms();
        $state = SmsManager::state();
//        dd($canSend,$sendResult,$state);
    }
}