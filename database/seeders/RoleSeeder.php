<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Puede consultar, crear, editar y eliminar usuarios.'
        ]);

        Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'Solo puede consultar datos.'
        ]);
    }
}
