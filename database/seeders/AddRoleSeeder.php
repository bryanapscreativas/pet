<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class AddRoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => Role::ADMIN,
        ]);
        Role::create([
            'name' => Role::USER,
        ]);
    }
}
