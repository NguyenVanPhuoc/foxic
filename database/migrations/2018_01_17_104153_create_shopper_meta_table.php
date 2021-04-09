<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopperMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopper_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cmnd')->nullabel();
            $table->date('date')->nullabel();
            $table->string('location')->nullabel();
            $table->string('image1')->nullabel();
            $table->string('image2')->nullabel();
            $table->integer('shopper_id');
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
        Schema::dropIfExists('shopper_meta');
    }
}
