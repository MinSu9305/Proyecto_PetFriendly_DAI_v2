<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('razas', function (Blueprint $table) {
            // Agregar la foreign key a especies
            $table->unsignedBigInteger('especie_id')->after('id');
            $table->foreign('especie_id')->references('id')->on('especies')->onDelete('cascade');
            
            // Mantener temporalmente el campo especie para migración
        });
    }

    public function down()
    {
        Schema::table('razas', function (Blueprint $table) {
            $table->dropForeign(['especie_id']);
            $table->dropColumn('especie_id');
        });
    }
};