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
            $table->string('user_id',16)->unique()->default("");
            $table->string('openid',34)->index()->default("");
            $table->string('headimgurl')->default("");
            $table->string('nickname',16)->default("");
            $table->string('phone',22)->index()->default("");
            $table->tinyInteger('user_type',false,true)->default(0);
            $table->tinyInteger('user_status',false,true)->default(0);
            $table->string('ip',16)->default("");
            $table->dateTime('user_last_login');
            $table->integer('user_money',false,true)->default(0);
            $table->integer('charging_total_cnt',false,true)->default(0);
            $table->integer('charging_total_time',false,true)->default(0);//秒为单位
            $table->string('api_token',60)->default("");
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
