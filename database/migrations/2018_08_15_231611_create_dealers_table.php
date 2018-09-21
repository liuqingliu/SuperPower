<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealersTable extends Migration
{
    /**
     * Run the migrations.
     * 经销商表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_card',32)->default("");
            $table->string('openid',34)->index()->default("");
            $table->string('parent_openid',34)->index()->default("");
            $table->string('province',16)->default("");
            $table->string('city',16)->default("");
            $table->string('area',32)->default("");
            $table->string('name',16)->default("");
            $table->integer('total_income',false,true)->default(0);//总收益
            $table->integer('income_withdraw',false,true)->default(0);//经销商可提现收益
            $table->integer('give_proportion',false,true)->default(0);//抽成比例值，计算需成0.01
            $table->string('remark')->default("");
            $table->string('password',16)->default("");
            $table->string('bank_username',32)->default("");
            $table->string('bank_name',32)->default("");
            $table->string('bank_no',32)->default("");
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
        Schema::dropIfExists('dealers');
    }
}
