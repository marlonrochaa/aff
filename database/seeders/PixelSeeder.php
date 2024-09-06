<?php

namespace Database\Seeders;

use App\Models\Pixel;
use Illuminate\Database\Seeder;

class PixelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {       
        $affiliate = \App\Models\Affiliate::updateOrCreate(
            ['email' => 'thiago@betvoa.com'],
            [
                'name' => 'Thiago',
                'email' => 'thiago@betvoa.com',
                'external_id' => '269578'
            ]);

        Pixel::updateOrCreate(
            ['affiliate_id' => $affiliate->id, 
            'type' => Pixel::TYPE_FACEBOOK
            ],
            [
                'type' => Pixel::TYPE_FACEBOOK,
                'name' => 'Facebook Pixel',
                'affiliate_id' => $affiliate->id,
                'value' => [
                    'access_token' => 'EAAO4wZA12RdUBO7lwxmcNdBI7sVUKdtA7VjF4Aoek1jrtThztiYbZB1Sl1ZCWsEdJsQ1xtkurVkOAHnQq0VYIHqrHgIW2CcbOmb5h2R8eCSyDZCe6zX3grBdGP61btUvhyTve6kUSVqWCwzk81xH9oCxwhzcbwMlndTatXmdnm9lOWf2Ks1OYu67ozPB0ZCfsLgZDZD',
                    'pixel_id' => '1968454427003729'
                ]
            ]
        );
    }
}