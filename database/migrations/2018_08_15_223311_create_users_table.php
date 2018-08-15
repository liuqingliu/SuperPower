<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 用户表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',16)->unique();
            $table->string('openid',34)->index();
            $table->string('headimgurl');
            $table->string('nickname',16);
            $table->string('phone',16)->index();
            $table->tinyInteger('user_type',false,true);
            $table->tinyInteger('user_status',false,true);
            $table->string('ip',16);
            $table->dateTime('user_last_login');
            $table->integer('user_money',false,true);
            $table->integer('charging_total_cnt',false,true);
            $table->integer('charging_total_time',false,true);//秒为单位
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
