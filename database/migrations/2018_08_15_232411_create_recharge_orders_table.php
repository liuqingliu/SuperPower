<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * 用户充电订单表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',34)->index()->default("");//订单号
            $table->string('recharge_str',34)->index()->default("");//用户编号
            $table->string('equipment_id',16)->index()->default("");//充电设备编号
            $table->string('port',16)->default("");//充电插口编号
            $table->unsignedInteger('recharge_total_time')->default(0);//需充电时长（根据用户选择标准来）
            $table->unsignedInteger('recharge_unit_second')->default(0);//充电单价
            $table->unsignedTinyInteger('recharge_status' )->default(0);//充电状态
            $table->timestamp('recharge_end_time');//充电结束时间
            $table->unsignedTinyInteger('type' )->default(0);//充电类型（user/card）
            $table->integer('wat',false,true)->default(0);//充电功率
            $table->integer('recharge_price',false,true)->default(0);//充电价格
            $table->unsignedTinyInteger('in_come_flag' )->default(0);//收入使用标记，是否录入流水
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
        Schema::dropIfExists('recharge_orders');
    }
}
