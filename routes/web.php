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

Route::get('/', function () {
    return 1;
});

Route::get('/login', 'UserController@center')->name('login')
//    ->middleware('wechat.oauth:default,snsapi_userinfo')
;//这里是登录

Route::any('/wechat', 'WeChatController@serve')->name("wechatserve");
Route::any('/payment/wechatnotify', 'PaymentController@wechatnotify')->name("wechatnotify");

Route::get('/user/center', 'UserController@center')->name('user_center');
//Route::get('captcha', function () {
//    $res = app('captcha')->create('default', true);
//    return $res;
//});

Route::post('/user/updateUserPhone', 'UserController@updateUserPhone')->name('updateUserPhone');

//Route::group(['middleware' => ['wechat.oauth:default,snsapi_userinfo','user.login']], function () {
    //用户
    Route::get('/user/detail', 'UserController@detail')->name('user_detail');
    Route::get('/user/bindphone', 'UserController@bindphone')->name('user_bindphone');
    Route::get('/user/order', 'UserController@order')->name('user_order');
    Route::get('/user/orderanswser', 'UserController@orderanswser')->name('user_orderanswer');
    Route::get('/user/center', 'UserController@center')->name('user_center');
    Route::get('/user/about', 'UserController@about')->name('user_about');
    //电卡
    Route::get('/electric/cardorderpay', 'ElectricController@cardorderpay')->name('electric_cardorderpay');
    Route::get('/electric/cardorderpayanswer', 'ElectricController@cardorderpayanswer')->name('electric_cardorderpayanswer');
    Route::get('/electric/recharge', 'ElectricController@recharge')->name('electric_recharge');
    Route::get('/electric/choosesocket', 'ElectricController@choosesocket')->name('electric_choosesocket');
    Route::get('/electric/rechargelog', 'ElectricController@rechargelog')->name('electric_rechargelog');
    Route::get('/electric/opensocket', 'ElectricController@openSocket')->name('electric_opensocket');
    Route::get('/electric/closesocket', 'ElectricController@closeSocket')->name('electric_closesocket');

    //api/
    Route::get('/api/getCaptcha', 'ApiController@getCaptcha')->name('getcaptcha');//获取图片验证码
    Route::post('/api/sendMessage', 'ApiController@sendMessage')->name('sendMessage');//发送短信验证码
    Route::post('/api/user/updateUserPhone', 'UserController@updateUserPhone')->name('updateuserphone');//更新用户手机号
    Route::post('/api/user/createOrder', 'UserController@createOrder')->name('createorder');//创建用户支付订单
    Route::post('/api/electric/createOrder', 'UserController@createOrder')->name('electriccreateorder');//创建电卡支付订单
    Route::get('/api/electric/getRechargeLog', 'ElectricController@getRechargeLog')->name('getrechargeLog');//获取用户的充电记录
    Route::post('/api/electric/stopChargingOrder', 'ElectricController@stopChargingOrder')->name('stopchargingorder');//停止充电
    Route::get('/api/electric/getElectricCardInfo', 'ElectricController@getElectricCardInfo')->name('getelectriccardinfo');//电卡详情
    Route::post('/api/electric/bindPhone', 'ElectricController@bindPhone')->name('bindPhone');//电卡绑定手机号

    //errors
    Route::get('/prompt','PromptController@index')->name("prompt");
    Route::get('/api/testmsn','ApiController@testmsn');
//});

Route::get("/api/testwu",'ApiController@testwu');
Route::get("/api/testGetMessage",'ApiController@testGetMessage');
Route::get('/api/sendMessage', 'ApiController@sendMessage')->name('sendMessage');//发送短信验证码
Route::get("/api/test","ApiController@test");

//Route::group(['middleware' => ['wechat.oauth:default,snsapi_userinfo','dealer.login']], function () {
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
Route::get('/dealer/revenueSummary', 'DealerController@revenueSummary')->name('dealer_revenueSummary');
Route::get('/dealer/takeOutMoney', 'DealerController@takeOutMoney')->name('dealer_takeOutMoney');
//});