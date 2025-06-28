<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'raza_id',
        'age',
        'size',
        'gender',
        'description',
        'images',
        'status',
        //'is_vaccinated',
        //'is_sterilized',
        //'medical_notes',
    ];

    protected $casts = [
        'images' => 'array',
        //'is_vaccinated' => 'boolean',
        //'is_sterilized' => 'boolean',
    ];

    public function raza()
    {
        return $this->belongsTo(Raza::class);
    }

    public function adoptionRequests()
    {
        return $this->hasMany(AdoptionRequest::class);
    }

    public function approvedAdoption()
    {
        return $this->hasOne(AdoptionRequest::class)->where('status', 'approved');
    }

    public function getTypeInSpanishAttribute()
    {
        return match($this->type) {
            'dog' => 'Perro',
            'cat' => 'Gato',
            //'other' => 'Otro',
            default => $this->type,
        };
    }

    public function getSizeInSpanishAttribute()
    {
        return match($this->size) {
            'small' => 'Pequeño',
            'medium' => 'Mediano',
            'large' => 'Grande',
            default => $this->size,
        };
    }

    public function getGenderInSpanishAttribute()
    {
        return match($this->gender) {
            'male' => 'Macho',
            'female' => 'Hembra',
            default => $this->gender,
        };
    }

    public function getStatusInSpanishAttribute()
    {
        return match($this->status) {
            'available' => 'Disponible',
            'adopted' => 'Adoptado',
            'pending' => 'Pendiente',
            default => $this->status,
        };
    }
}
