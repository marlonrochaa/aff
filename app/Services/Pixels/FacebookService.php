<?php

namespace App\Services\Pixels;

use App\Models\Pixel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookService
{
    private $accessToken;
    private $pixelId;

    public function __construct($affiliate)
    {
        $pixel = Pixel::where('type', Pixel::TYPE_FACEBOOK)
        ->where('affiliate_id', $affiliate->id)
        ->first();

        $this->accessToken = $pixel->value['access_token'];
        $this->pixelId = $pixel->value['pixel_id'];
    }

    public function sendPixel(string $eventName, $player): void
    {
        $data = [
            'event_name' => $eventName,
            'event_time' => time(),
            'user_data' => [
                'em' => hash('sha256', $player->email),
                'ph' => hash('sha256', $player->phone),
                'fn' => hash('sha256', $player->name),
                'ln' => hash('sha256', $player->name),
                'external_id' => hash('sha256', $player->external_id),
            ],
            'custom_data' => [],
        ];
        
        if (!$player->params->isEmpty()) {
            $data['custom_data']['utm_source'] = $player->params->first()->parameters['utm_source'];
            $data['custom_data']['utm_campaign'] = $player->params->first()->parameters['utm_campaign'];
            //$data['custom_data']['utm_medium'] = $player->params->first()->parameters['utm_medium'];
            $data['custom_data']['utm_content'] = $player->params->first()->parameters['utm_content'];
        }
        
        $jsonData = json_encode($data);

        $reponse = Http::post("https://graph.facebook.com/v19.0/{$this->pixelId}/events", [
            'data' => [
                $jsonData,
            ],
            'access_token' => $this->accessToken,
        ]);

        //salva o log
        LOG::info(json_encode($jsonData));
        Log::info($reponse->json());
    }

    //envia evento teste de pixel do evento betvoa_lead e ftd e  Redeposit
    public function sendTestPixel()
    {
        $player = new \stdClass();
        $player->email = 'test@email.com';
        $player->phone = '123456789';
        $player->name = 'Teste';
        $player->external_id = '123456789';
        $player->params = collect([]);

        $this->sendPixel('betvoa_lead', $player);
        $this->sendPixel('Ftd', $player);
        $this->sendPixel('Redeposit', $player);

        return true;
    }
}