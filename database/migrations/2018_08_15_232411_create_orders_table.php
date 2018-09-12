<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * 用户充值订单表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',16)->unique()->default("");
            $table->string('card_id',16)->index()->default("");
            $table->integer('price',false,true)->default(0);
            $table->tinyInteger('order_status',false,true)->default(0);
            $table->string('openid',34)->index()->default("");
            $table->tinyInteger('order_type',false,true)->default(0);
            $table->string('pay_id',64)->default("");//支付回调id（真正的支付id）
            $table->string('extends')->default("");
            $table->unsignedTinyInteger('type' )->default(0);//充电类型（user/card）
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
        Schema::dropIfExists('orders');
    }
}
