<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api']], function () {
//    Route::get('/getCaptcha', 'ApiController@getCaptcha')->name('getcaptcha');//获取图片验证码
//    Route::post('/sendMessage', 'ApiController@sendMessage')->name('sendMessage');//发送短信验证码
//    Route::post('/user/updateUserPhone', 'UserController@updateUserPhone')->name('updateuserphone');//更新用户手机号
//    Route::post('/user/createOrder', 'UserController@createOrder')->name('createorder');//创建用户支付订单
//    Route::post('/electric/createOrder', 'UserController@createOrder')->name('electriccreateorder');//创建电卡支付订单
//    Route::get('/electric/getRechargeLog', 'ElectricController@getRechargeLog')->name('getrechargeLog');//获取用户的充电记录
//    Route::post('/electric/stopChargingOrder', 'ElectricController@stopChargingOrder')->name('stopchargingorder');//停止充电
//    Route::get('/electric/getElectricCardInfo', 'ElectricController@getElectricCardInfo')->name('getelectriccardinfo');//电卡详情
//    Route::post('/electric/bindPhone', 'ElectricController@bindPhone')->name('bindPhone');//电卡绑定手机号
});

Route::get('/testredis', 'ApiController@testredis')->name('testredis');