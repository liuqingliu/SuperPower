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
            $table->string('order_id',16)->unique();
            $table->string('user_id',16)->unique();
            $table->string('id_card',32);
            $table->string('parent_user_id',16)->index();
            $table->string('province',16);
            $table->string('city',16);
            $table->string('area',32);
            $table->string('name',16);
            $table->integer('total_income',false,true);//总收益
            $table->integer('income_withdraw',false,true);//经销商可提现收益
            $table->integer('give_proportion',false,true);//抽成比例值，计算需成0.01
            $table->string('remark');
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
