<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBestShoppersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_shoppers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cmnd')->nullable();
            $table->integer('shopper_id')->nullable();
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
        Schema::dropIfExists('best_shoppers');
    }
}
