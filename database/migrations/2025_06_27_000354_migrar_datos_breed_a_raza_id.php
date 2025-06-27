<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pet;
use App\Models\Raza;

return new class extends Migration
{
    public function up()
    {
        // Migrar datos existentes
        $pets = Pet::whereNotNull('breed')->get();
        
        foreach ($pets as $pet) {
            // Convertir type de inglés a español
            $especieEspanol = match($pet->type) {
                'dog' => 'Perro',
                'cat' => 'Gato',
                default => null
            };
            
            if ($especieEspanol) {
                // Buscar o crear la raza
                $raza = Raza::firstOrCreate([
                    'nombre' => $pet->breed,
                    'especie' => $especieEspanol
                ], [
                    'descripcion' => "Raza migrada automáticamente: {$pet->breed}"
                ]);
                
                // Asignar la raza_id al pet
                $pet->update(['raza_id' => $raza->id]);
            }
        }
    }

    public function down()
    {
        // Restaurar datos del campo breed basado en raza_id
        $pets = Pet::whereNotNull('raza_id')->with('raza')->get();
        
        foreach ($pets as $pet) {
            if ($pet->raza) {
                $pet->update(['breed' => $pet->raza->nombre]);
            }
        }
    }
};