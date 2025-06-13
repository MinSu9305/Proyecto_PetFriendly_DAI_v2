<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['dog', 'cat', 'other']);
            $table->string('breed')->nullable();
            $table->integer('age');
            $table->enum('size', ['small', 'medium', 'large']);
            $table->enum('gender', ['male', 'female']);
            $table->text('description');
            $table->json('images')->nullable();
            $table->enum('status', ['available', 'adopted', 'pending'])->default('available');
            $table->boolean('is_vaccinated')->default(false);
            $table->boolean('is_sterilized')->default(false);
            $table->text('medical_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
