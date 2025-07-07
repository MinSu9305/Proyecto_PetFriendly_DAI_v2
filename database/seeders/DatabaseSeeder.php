<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
use App\Models\AdoptionRequest;
use App\Models\Donation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador Pet Friendly',
            'email' => 'admin@petfriendly.com',
            'birth_date' => '1990-01-01',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
    }
}
