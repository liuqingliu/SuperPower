<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRechargeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * 用户充电订单表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_recharge_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',16)->index()->default("");//用户编号
            $table->string('equipment_id',16)->index()->default("");//充电设备编号
            $table->string('jack_id',16)->default("");//充电插口编号
            $table->unsignedInteger('recharge_total_time')->default(0);//需充电时长（根据用户选择标准来）
            $table->unsignedInteger('recharge_unit_money')->default(0);//充电单价
            $table->unsignedTinyInteger('recharge_status' )->default(0);//充电状态
            $table->unsignedInteger('recharge_time',false)->default(0);//充电时长
            $table->integer('wat',false,true)->default(0);//充电功率
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_recharge_orders');
    }
}
