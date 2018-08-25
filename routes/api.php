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
    Route::get('/user/updateUserPhone', 'UserController@updateUserPhone')->name('updateuserphone');//更新用户手机号
    Route::get('/user/createOrder', 'UserController@createOrder')->name('createorder');//更新用户手机号
    Route::get('/electric/getRechargeLog', 'ElectricController@getRechargeLog');//获取用户的充电记录
    Route::post('/electric/updateChargingOrder', 'ElectricController@updateChargingOrder');//停止充电
    Route::get('/electric/getElectricCardInfo', 'ElectricController@getElectricCardInfo');//电卡详情
    Route::post('/electric/bindPhone', 'ElectricController@bindPhone');//电卡绑定手机号
});