<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('razas', function (Blueprint $table) {
            // Eliminar el campo especie (enum) ya que ahora usamos especie_id
            $table->dropColumn('especie');
        });
    }

    public function down()
    {
        Schema::table('razas', function (Blueprint $table) {
            // Restaurar el campo especie por si necesitas hacer rollback
            $table->enum('especie', ['Perro', 'Gato'])->after('nombre');
        });
    }
};