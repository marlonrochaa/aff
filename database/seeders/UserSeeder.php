<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //cria um usuário admin do fillament
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@betvoa.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@betvoa.com',
                'password' => bcrypt('AczT3z8z')
            ]);

    }
}
