<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_picture')->default('https://img.freepik.com/free-vector/isolated-young-handsome-man-different-poses-white-background-illustration_632498-850.jpg?w=740&t=st=1699559657~exp=1699560257~hmac=c89654a67c37b1ab4256b231ced106ede42ae1f6ce6ea2c24f54516875b1fbde');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
