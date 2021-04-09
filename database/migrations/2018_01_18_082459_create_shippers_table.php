<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug',255)->nullable();
            $table->string('sex')->nullable();
            $table->string('birthday')->nullable();
            $table->string('address',255)->nullable();            
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('phone')->unique();
            $table->string('password',60);
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
        Schema::dropIfExists('shippers');
    }
}
