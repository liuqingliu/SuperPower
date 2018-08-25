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
            $table->string('order_id',16)->unique()->default("");
            $table->integer('price',false,true)->default(0);
            $table->tinyInteger('order_status',false,true)->default(0);
            $table->string('openid',34)->index()->default("");
            $table->tinyInteger('order_type',false,true)->default(0);
            $table->string('pay_id',64)->default("");//支付回调id（真正的支付id）
            $table->string('extends')->default("");
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
        Schema::dropIfExists('user_orders');
    }
}
