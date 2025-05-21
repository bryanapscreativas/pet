<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            if (User::where('email', 'ventas@apscreativas.com')->exists()) {
                return;
            }

            $user = User::create([
                'full_name' => 'Administrador',
                'email' => 'ventas@apscreativas.com',
                'password' => 'Aplicaciones.2017', // Se hasheará automáticamente por el cast
            ]);

            $role = Role::where('name', Role::ADMIN)->first();
            $user->roles()->attach($role->id);
        });
    }
}
