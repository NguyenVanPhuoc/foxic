<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipperMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipper_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cmnd')->nullabel();
            $table->date('date')->nullabel();
            $table->string('location')->nullabel();
            $table->string('cmnd1')->nullabel();
            $table->string('cmnd2')->nullabel();
            $table->string('driver_license1')->nullabel();
            $table->string('driver_license2')->nullabel();
            $table->string('driver_photo')->nullabel();
            $table->string('driver_name')->nullabel();
            $table->string('driver_number')->nullabel();
            $table->integer('shipper_id');
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
        Schema::dropIfExists('shipper_meta');
    }
}
