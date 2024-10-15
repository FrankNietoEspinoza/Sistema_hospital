<?php

namespace Database\Seeders;

// database/seeders/UserSeeder.php
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Recepcionista',
            'email' => 'recepcionista@example.com',
            'password' => Hash::make('password'),
            'perfil' => 'recepcionista',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'perfil' => 'admin',
        ]);
    }
}
