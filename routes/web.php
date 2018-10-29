<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    return 1;
});
//errors
Route::get('/prompt','PromptController@index')->name("prompt");
Route::get('/login', 'UserController@center')->name('login')
    ->middleware('wechat.oauth:default,snsapi_userinfo')
;//这里是登录

Route::any('/wechat', 'WeChatController@serve')->name("wechatserve");
Route::any('/payment/wechatnotify', 'PaymentController@wechatnotify')->name("wechatnotify");

Route::get('/user/center', 'UserController@center')->name('user_center')
    ->middleware('wechat.oauth:default,snsapi_userinfo');

//Route::get('/api/sendMessage', 'ApiController@sendMessage')->name('sendMessage');//发送短信验证码
Route::group(['middleware' => ['user.login']], function () {
    //管理员设置微信
    Route::get('/wechat/createWechatMenu', 'WeChatController@createWechatMenu')->name('create_wechat_menu');
    //用户
    Route::get('/user/detail', 'UserController@detail')->name('user_detail');
    Route::get('/user/bindphone', 'UserController@bindphone')->name('user_bindphone');
    Route::get('/user/order', 'UserController@order')->name('user_order');
    Route::get('/user/orderanswser', 'UserController@orderanswser')->name('user_orderanswer');
    Route::get('/user/about', 'UserController@about')->name('user_about');
    //电卡
    Route::get('/electric/cardorderpay', 'ElectricController@cardorderpay')->name('electric_cardorderpay');
    Route::get('/electric/cardorderpayanswer', 'ElectricController@cardorderpayanswer')->name('electric_cardorderpayanswer');
    Route::get('/electric/recharge', 'ElectricController@recharge')->name('electric_recharge');
    Route::get('/electric/choosesocket', 'ElectricController@choosesocket')->name('electric_choosesocket');
    Route::get('/electric/rechargelog', 'ElectricController@rechargelog')->name('electric_rechargelog');
    Route::post('/electric/opensocket', 'ElectricController@openSocket')->name('electric_opensocket');
    Route::post('/electric/closesocket', 'ElectricController@closeSocket')->name('electric_closesocket');

    //api/
    Route::get('/api/getCaptcha', 'ApiController@getCaptcha')->name('getcaptcha');//获取图片验证码
    Route::post('/api/sendMessage', 'ApiController@sendMessage')->name('sendMessage');//发送短信验证码
    Route::get('/user/updateUserPhone', 'UserController@updateUserPhone')->name('updateuserphone');//更新用户手机号
    Route::post('/user/createOrder', 'UserController@createOrder')->name('createorder');//创建用户支付订单
    Route::post('/electric/createOrder', 'ElectricController@createOrder')->name('electriccreateorder');//创建电卡支付订单
    Route::get('/electric/getRechargeLog', 'ElectricController@getRechargeLog')->name('getrechargeLog');//获取用户的充电记录
    Route::post('/electric/stopChargingOrder', 'ElectricController@stopChargingOrder')->name('stopchargingorder');//停止充电
    Route::get('/electric/getElectricCardInfo', 'ElectricController@getElectricCardInfo')->name('getelectriccardinfo');//电卡详情
    Route::post('/electric/bindPhone', 'ElectricController@bindPhone')->name('bindPhone');//电卡绑定手机号
    Route::get('/api/capTest','ApiController@capTest')->name('capTest');
});

Route::group(['middleware' => ['dealer.login']], function () {
//经销商
    Route::get('/dealer/cardManage', 'DealerController@electriccardmanage')->name('dealer_electriccardmanage');
    Route::get('/dealer/center', 'DealerController@center')->name('dealer_center');
    Route::get('/dealer/dealerDetail', 'DealerController@dealerDetail')->name('dealer_detail');
    Route::get('/dealer/dealerManage', 'DealerController@dealerManage')->name('dealer_manage');
    Route::get('/dealer/incomeAndExpense', 'DealerController@incomeAndExpense')->name('dealer_incomeexpense');
    Route::get('/dealer/moneyManage', 'DealerController@moneyManage')->name('dealer_moneymanage');
    Route::get('/dealer/powerStationDetail', 'DealerController@powerStationDetail')->name('dealer_powerStationDetail');
    Route::get('/dealer/powerStationManage', 'DealerController@powerStationManage')->name('dealer_powerStationManage');
    Route::get('/dealer/resetPassword', 'DealerController@resetPassword')->name('dealer_resetPassword');
    Route::post('/dealer/doResetPassword', 'DealerController@doResetPassword')->name('dealer_doResetPassword');//经销商充值密码
    Route::post('/dealer/doSetPassword', 'DealerController@doSetPassword')->name('dealer_dosetPassword');//经销商设置密码
    Route::get('/dealer/revenueSummary', 'DealerController@revenueSummary')->name('dealer_revenueSummary');
    Route::get('/dealer/takeOutMoney', 'DealerController@takeOutMoney')->name('dealer_takeOutMoney');//
    Route::get('/dealer/getDealerList', 'DealerController@getDealerList')->name('getDealerList');//获取经销商列表接口
    Route::get('/dealer/getCashLogList', 'DealerController@getDealerList')->name('getCashLogList');//获取收入明细列表
    Route::post('/dealer/doTixian', 'DealerController@doTixian')->name('doTixian');//经销商提现接口
    Route::get('/dealer/bindBank', 'DealerController@bindBank')->name('bindBank');
    Route::post('/dealer/doBindBank', 'DealerController@doBindBank')->name('doBindBank');//绑定各银行卡
    Route::post('/dealer/doAddDealer', 'DealerController@doAddDealer')->name('doAddDealer');//添加经销商接口
    Route::post('/dealer/doUpdateDealer', 'DealerController@doUpdateDealer')->name('doUpdateDealer');//添加经销商接口
    Route::get('/dealer/getEquipmentInfo', 'DealerController@getEquipmentInfo')->name('getEquipmentInfo');//添加电站接口
    Route::post('/dealer/doUpdateEquipment', 'DealerController@doUpdateEquipment')->name('doUpdateEquipment');//电站查询接口
    Route::get('/dealer/getDealerInfo', 'DealerController@getDealerInfo')->name('getDealerInfo');//经销商查询接口
    Route::get('/dealer/getEquipmentInfoList',
        'DealerController@getEquipmentInfoList')->name('getEquipmentInfoList');//经销商查询接口
});