<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikedSneakersTable extends Migration
{
    public function up()
    {
        Schema::create('liked_sneakers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sneaker_id');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sneaker_id')->references('id')->on('sneakers')->onDelete('cascade');
            
            // Add unique constraint to prevent duplicate likes by the same user
            $table->unique(['user_id', 'sneaker_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('liked_sneakers');
    }
}
