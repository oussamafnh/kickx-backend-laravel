<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSneakersTable extends Migration
{
    public function up()
    {
        Schema::create('sneakers', function (Blueprint $table) {
            $table->id();
            $table->string('sneaker_name');
            $table->decimal('price', 8, 2); // Adjust precision and scale as needed
            $table->text('description')->nullable();
            $table->string('colorway')->nullable();
            $table->unsignedSmallInteger('release_year');
            $table->string('brand');
            $table->string('gender');
            $table->string('image_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sneakers');
    }
}
