<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('especies', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Perro, Gato, etc.
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('especies');
    }
};