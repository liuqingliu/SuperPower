<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTixiansTable extends Migration
{
    /**
     * Run the migrations.
     * 经销商表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tixians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid',34)->index()->default("");
            $table->unsignedInteger('money')->default("0");
            $table->unsignedTinyInteger('status')->default(0);
            $table->string('remark')->default("");
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
        Schema::dropIfExists('tixians');
    }
}
