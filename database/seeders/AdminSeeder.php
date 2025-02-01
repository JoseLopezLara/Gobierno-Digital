<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creación de usarion administrador de...
        // Nombre: Andoney Betancourt Castillo
        // Email: andoney.betancourtc@sfa.michoacan.gob.mx
        // Contraseña: password_no_segura

        $adminUser = User::create([
            'name' => 'Andoney Betancourt Castillo',
            'email' => 'andoney.betancourtc@sfa.michoacan.gob.mx',
            'password' => bcrypt('password_no_segura'),
        ]);

        $adminRole = Role::where('slug', 'admin')->first();

        $adminUser->roles()->attach($adminRole->id);
    }
}

