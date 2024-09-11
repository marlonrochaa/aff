<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            'Afiliado',
            'Influenciador',
            'Gerente'
        ];

        foreach ($profiles as $profile) {
            \App\Models\Profile::updateOrCreate(
                ['name' => $profile],
                ['name' => $profile]
            );
        }
    }
}
