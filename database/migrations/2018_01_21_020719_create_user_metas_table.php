<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cmnd')->nullable();
            $table->date('cmnd_date')->nullable();
            $table->string('cmnd_location')->nullable();
            $table->string('cmnd_before')->nullable();
            $table->string('cmnd_after')->nullable();
            $table->string('driver_license1')->nullable();
            $table->string('driver_license2')->nullable();
            $table->string('driver_photo')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_number')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_metas');
    }
}
