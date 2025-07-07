<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    use HasFactory;

    protected $table = 'especies';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // Relación con razas
    public function razas()
    {
        return $this->hasMany(Raza::class, 'especie_id');
    }

    // Relación con mascotas
    public function mascotas()
    {
        return $this->hasMany(Pet::class, 'especie_id');
    }
    
}