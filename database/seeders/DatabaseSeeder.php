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

        // Crear usuarios adoptantes de prueba
        $adoptantes = [
            [
                'name' => 'María Angélica',
                'email' => 'mangellica@gmail.com',
                'birth_date' => '1995-03-15',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jose Suarez',
                'email' => 'josesuarez@gmail.com',
                'birth_date' => '1988-07-22',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'María Torres',
                'email' => 'torres_maria@gmail.com',
                'birth_date' => '1992-11-08',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Carlos Mendoza',
                'email' => 'cmendoza@gmail.com',
                'birth_date' => '1985-05-12',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ana García',
                'email' => 'ana.garcia@gmail.com',
                'birth_date' => '1993-09-30',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Luis Rodríguez',
                'email' => 'luis.rodriguez@gmail.com',
                'birth_date' => '1987-12-18',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($adoptantes as $adoptante) {
            User::create($adoptante);
        }




        // Crear donaciones
        $donaciones = [
            [
                'user_id' => 2,
                'donor_name' => 'María Angélica',
                'donor_email' => 'mangellica@gmail.com',
                'amount' => 50.00,
                'status' => 'completed',
                'message' => 'Para ayudar a los animalitos',
            ],
            [
                'user_id' => 3,
                'donor_name' => 'Jose Suarez',
                'donor_email' => 'josesuarez@gmail.com',
                'amount' => 100.00,
                'status' => 'completed',
                'message' => 'Donación mensual',
            ],
            [
                'user_id' => null,
                'donor_name' => 'Anónimo',
                'donor_email' => 'anonimo@gmail.com',
                'amount' => 25.00,
                'status' => 'completed',
                'message' => 'Pequeña ayuda',
            ],
        ];

        foreach ($donaciones as $donacion) {
            Donation::create($donacion);
        }
    }
}
