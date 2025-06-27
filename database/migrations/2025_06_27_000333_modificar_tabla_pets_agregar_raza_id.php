<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            // Agregar la nueva columna raza_id
            $table->unsignedBigInteger('raza_id')->nullable()->after('type');
            
            // Crear la foreign key
            $table->foreign('raza_id')->references('id')->on('razas')->onDelete('set null');
            
            // Mantener temporalmente el campo breed para migración de datos
            // Lo eliminaremos en una migración posterior
        });
    }

    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropForeign(['raza_id']);
            $table->dropColumn('raza_id');
        });
    }
};