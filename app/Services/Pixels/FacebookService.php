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

    public function sendPixel(string $eventName, $player): void
    {
        $data = json_encode([
            'event_name' => $eventName,
            'event_time' => time(),
            'user_data' => [
                'em' => hash('sha256', $player->email),
                'ph' => hash('sha256', $player->phone),
                'fn' => hash('sha256', $player->name),
                'ln' => hash('sha256', $player->name),
                'external_id' => hash('sha256', $player->external_id),
            ],

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