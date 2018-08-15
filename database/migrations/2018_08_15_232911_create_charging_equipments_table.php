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
            $table->string('province',16);
            $table->string('city',16);
            $table->string('area',32);
            $table->string('street',32);
            $table->string('address',64);
            $table->tinyInteger('equipment_status',false, true);
            $table->string('jack_info');
            $table->tinyInteger('net_status',false,true);//联网状态
            $table->integer('charging_cost',false,true);//充电成本
            $table->integer('charging_unit_price',false,true);//充电单价
            $table->dateTime('active_time');
            $table->string('parent_user_id',16)->index();
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
        Schema::dropIfExists('users');
    }
}
