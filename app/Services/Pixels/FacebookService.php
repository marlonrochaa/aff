<?php

namespace App\Services\Pixels;

use App\Models\Pixel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookService
{
    private $accessToken;
    private $pixelId;

    public function __construct()
    {
        $pixel = Pixel::where('type', Pixel::TYPE_FACEBOOK)->first();

        $this->accessToken = $pixel->value['access_token'];
        $this->pixelId = $pixel->value['pixel_id'];
    }

    public function sendPixel(string $eventName): void
    {
        $data = json_encode([
            'event_name' => $eventName,
            'event_time' => time(),
            //'event_source_url' => config('app.url'),
            //'user_data' => [],
            //'custom_data' => $eventData,
        ]);

        $reponse = Http::post("https://graph.facebook.com/v19.0/{$this->pixelId}/events", [
            'data' => [
                $data,
            ],
            'access_token' => $this->accessToken,
        ]);

        //salva o log
        Log::info($reponse->json());
    }
}