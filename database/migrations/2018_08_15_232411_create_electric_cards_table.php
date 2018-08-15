<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricCardsTable extends Migration
{
    /**
     * Run the migrations.
     * 电卡信息表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electric_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_id',16)->unique();
            $table->string('bind_phone',16);
            $table->tinyInteger('card_status',false,true);
            $table->string('parent_user_id',16)->index();
            $table->dateTime('active_time');
            $table->integer('money',false,true);//电卡余额
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
