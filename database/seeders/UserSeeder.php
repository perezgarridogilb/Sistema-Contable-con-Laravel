<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Israel González Zacarías',
            'phone' => '2222222222',
            'email' => 'secarmesi@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('passwrd')
        ]);
        User::create([
            'name' => 'Juan Márquez Solís',
            'phone' => '2222222221',
            'email' => 'secarmesi1@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('passwrd')
        ]);
        User::create([
            'name' => 'Marcos Mártinez Fernández',
            'phone' => '2222222223',
            'email' => 'gilberto.perezga@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('passwrd')
        ]);
    }
}
