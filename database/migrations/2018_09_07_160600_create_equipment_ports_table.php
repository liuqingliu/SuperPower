<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentPortsTable extends Migration
{
    /**
     * Run the migrations.
     * 用户表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_ports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('equipment_id',16)->default("");
            $table->integer('port',false,true)->default(0);
            $table->tinyInteger('status',false,true)->default(0);
            $table->timestamps();
            $table->unique(['equipment_id', 'port']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_ports');
    }
}
