<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricRechargeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * 电卡充电订单表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electric_recharge_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_id',16)->index()->default("");//电卡号
            $table->string('equipment_id',16)->index()->default("");//充电设备编号
            $table->string('jack_id',16)->default("");//充电插口编号
            $table->integer('recharge_unit_money',false,true)->default(0);//充电单价
            $table->unsignedTinyInteger('recharge_status' )->default(0);//充电状态
            $table->integer('recharge_time',false,true)->default(0);//充电时长
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
        Schema::dropIfExists('electric_recharge_orders');
    }
}
