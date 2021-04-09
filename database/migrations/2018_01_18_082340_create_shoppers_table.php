<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug',255)->nullable();
            $table->string('address',255)->nullable();            
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('phone')->unique();
            $table->string('passsword',60);
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
        Schema::dropIfExists('shoppers');
    }
}
