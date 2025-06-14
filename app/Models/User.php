<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**

     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'role',
        'last_login_at',
        'password',
        'profile_photo_path',
        'dni',
        'phone',
    ];

    /**
    
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
    
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function getAgeAttribute()
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->age : null;
    }


    public function isAdult()
    {
        return $this->age >= 20;
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=FFFFFF&background=FCD34D';
    }

    
    public function adoptionRequests()
    {
        return $this->hasMany(AdoptionRequest::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function approvedAdoptions()
    {
        return $this->hasMany(AdoptionRequest::class, 'approved_by');
    }
}
