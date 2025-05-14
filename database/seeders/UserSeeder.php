<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'full_name' => 'Administrador',
            'email' => 'ventas@apscreativas.com',
            'password' => bcrypt('Aplicaciones.2017'),
        ]);
    }
}
