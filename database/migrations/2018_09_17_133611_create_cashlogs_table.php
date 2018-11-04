<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashlogsTable extends Migration
{
    /**
     * Run the migrations.
     * 经销商表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid',34)->index()->default("");
            $table->string('equipment_id',16)->index()->default("");
            $table->string('cash_id',34)->index()->default("");
            $table->unsignedTinyInteger('cash_type')->default(0);
            $table->unsignedTinyInteger('cash_status')->default(0);
            $table->unsignedInteger('cash_price')->default(0);
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
        Schema::dropIfExists('cash_logs');
    }
}
