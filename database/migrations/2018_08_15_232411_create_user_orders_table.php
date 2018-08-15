<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * 用户充值订单表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',16)->unique();
            $table->integer('price',false,true);
            $table->tinyInteger('order_status',false,true);
            $table->string('openid',34)->index();
            $table->tinyInteger('order_type',false,true);
            $table->string('pay_id',64);//支付回调id（真正的支付id）
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
