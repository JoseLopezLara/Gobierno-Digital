<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Biscamos el rol de interes a travez del slug, es este caso el "user"
        $userRole = Role::where('slug', 'user')->first();

        // Creamos los 15 usarios especificados como requerimiento y le asociamos el role
        User::factory(15)->create()->each(function ($user) use ($userRole) {
            $user->roles()->attach($userRole->id);
        });

    }
}
