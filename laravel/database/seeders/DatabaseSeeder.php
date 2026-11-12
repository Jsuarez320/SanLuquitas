<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Crea el primer administrador (credenciales configurables por .env).
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => env('ADMIN_USERNAME', 'admin')],
            [
                'name' => 'Administrador',
                'apellido' => 'Sistema',
                'email' => env('ADMIN_EMAIL', 'admin@sanluquitas.test'),
                'password' => env('ADMIN_PASSWORD', 'Cambiar123'),
                'es_admin' => true,
                'activo' => true,
            ],
        );
    }
}
