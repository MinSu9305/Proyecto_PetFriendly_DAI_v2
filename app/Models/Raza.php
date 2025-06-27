<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    use HasFactory;

    protected $table = 'razas';

    protected $fillable = [
        'nombre',
        'especie',
        'descripcion'
    ];

    // Relación con mascotas (si la necesitas más adelante)
    public function mascotas()
    {
        return $this->hasMany(Pet::class, 'raza_id');
    }
}