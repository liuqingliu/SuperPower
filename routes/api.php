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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/user/updateUserPhone', 'UserController@updateUserPhone');//更新用户手机号
    Route::get('/electric/getRechargeLog', 'ElectricController@getRechargeLog');//获取用户的充电记录
    Route::post('/electric/updateChargingOrder', 'ElectricController@updateChargingOrder');//停止充电
    Route::get('/electric/getElectricCardInfo', 'ElectricController@getElectricCardInfo');//电卡详情
    Route::post('/electric/bindPhone', 'ElectricController@bindPhone');//电卡绑定手机号
});