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
        Pixel::updateOrCreate(
            ['type' => Pixel::TYPE_FACEBOOK],
            [
                'type' => Pixel::TYPE_FACEBOOK,
                'value' => [
                    'access_token' => 'EAAcGZC3y6F6IBO7PQoVxdASKEtdi5ZCw7PQMcZCzJQdJzttoRqzqrCq5ySeEKdBnwyxvyRrL4ZC8r3QzgtfijkpdbdwOlhCVoUmfDBsXEgpDIkbcu1nNck6owbLUhn2OGZBhtwmEwNsnbPMXzg7fR8pdfwU3ZAXXgbZBarzZCcs2lDvlAhHBqFqGvMdt9wf8ZCkZAPiwZDZD',
                    'pixel_id' => '535577605462079'
                ]
            ]
        );
    }
}