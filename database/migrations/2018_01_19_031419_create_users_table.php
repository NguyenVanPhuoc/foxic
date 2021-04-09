<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone')->unique();
            $table->string('password',60);            
            $table->string('name');             
            $table->string('slug',255)->nullable();            
            $table->string('email')->unique();
            $table->string('birthday')->nullable();
            $table->string('sex',10);
            $table->string('address',255)->nullable();  
            $table->string('level');
            $table->string('image')->nullable();
            // $table->string('remember_token', 100)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
