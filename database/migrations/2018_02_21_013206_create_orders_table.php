<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tracking',100);
            $table->string('title');
            $table->string('slug',255)->nullable();            
            $table->string('price_package')->nullable();
            $table->string('price_company')->nullable();
            $table->string('price_driver')->nullable();
            $table->string('price_total')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('status',50)->nullable();
            $table->integer('shopper_id')->unsigned();
            $table->foreign('shopper_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('shipper_id')->unsigned();
            $table->foreign('shipper_id')->references('id')->on('users')->onDelete('cascade');
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
