<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargingEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     * 设备信息表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('equipment_id',16)->unique();
            $table->string('province',16)->default("");
            $table->string('city',16)->default("");
            $table->string('area',32)->default("");
            $table->string('street',32)->default("");
            $table->string('address',64)->default("");
            $table->tinyInteger('equipment_status',false, true)->default(0);
            $table->string('jack_info')->default("");
            $table->string('board_info')->default("");
            $table->tinyInteger('net_status',false,true)->default(0);//联网状态
            $table->integer('charging_cost',false,true)->default(0);//充电成本
            $table->integer('charging_unit_price',false,true)->default(0);//充电单价
            $table->dateTime('active_time');
            $table->string('manager_phone',22)->index()->default("");
            $table->string('openid',16)->index();
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
        Schema::dropIfExists('charging_equipments');
    }
}
