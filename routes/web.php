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

Route::get('/mailable', function () {
    $invoice = App\Invoice::find(1);

    return new App\Mail\InvoicePaid($invoice);
});


Route::get('/login', 'UserController@center')->name('login')->middleware('wechat.oauth:default,snsapi_userinfo');//这里是登录

Route::any('/wechat', 'WeChatController@serve')->name("wechatserve");
Route::any('/payment/wechatnotify', 'PaymentController@wechatnotify')->name("wechatnotify");

Route::get('/user/center', 'UserController@center')->name('user_center')->middleware('wechat.oauth:default,snsapi_userinfo');

Route::group(['middleware' => ['wechat.oauth:default,snsapi_userinfo','user.login']], function () {
    Route::get('/user/detail', 'UserController@detail')->name('user_detail');
    Route::get('/user/bindphone', 'UserController@bindphone')->name('user_bindphone');
    Route::get('/user/order', 'UserController@order')->name('user_order');
    Route::get('/user/orderanswser', 'UserController@orderanswser')->name('user_orderanswer');
    Route::get('/user/about', 'UserController@about')->name('user_about');
    Route::get('/electric/cardorderpay', 'ElectricController@cardorderpay')->name('electric_cardorderpay');
    Route::get('/electric/cardorderpayanswer', 'ElectricController@cardorderpayanswer')->name('electric_cardorderpayanswer');
    Route::get('/electric/recharge', 'ElectricController@recharge')->name('electric_recharge');
    Route::get('/electric/choosesocket', 'ElectricController@choosesocket')->name('electric_choosesocket');
    Route::get('/electric/rechargelog', 'ElectricController@rechargelog')->name('electric_rechargelog');
    Route::get('/dealer/center', 'DealerController@center')->name('dealer_center');
    Route::get('/dealer/electriccardmanage', 'DealerController@electriccardmanage')->name('dealer_electriccardmanage');
    Route::get('/dealer/electricstationmanage', 'DealerController@electricstationmanage')->name('dealer_electricstationmanage');
    Route::get('/dealer/manage', 'DealerController@manage')->name('dealer_manage');
    Route::get('/dealer/moneymanage', 'DealerController@moneymanage')->name('dealer_moneymanage');
});
