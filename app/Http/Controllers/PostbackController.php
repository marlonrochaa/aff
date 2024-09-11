<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\WebhookProcessor;
use App\Models\Param;
use App\Models\Pixel;
use App\Models\Player;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostbackController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // Verificar se o player já existe
        $player = Player::firstOrCreate(
            ['external_id' => $payload['user_id']],
            [
                'name' => $payload['user_name'],
                'email' => $payload['user_email'],
                'phone' => $payload['user_phone'],
            ]
        );

        // Salvar parâmetros do player
        Param::updateOrCreate(
            ['player_id' => $player->id],
            ['parameters' => [
                'src' => $payload['src'] ?? null,
                'utm_source' => $payload['utm_source'] ?? null,
                'utm_campaign' => $payload['utm_campaign'] ?? null,
                'utm_medium' => $payload['utm_medium'] ?? null,
                'utm_content' => $payload['utm_content'] ?? null,
            ]]
        );

        // Salvar o evento do webhook
        $webhookEvent = WebhookEvent::create([
            'player_id' => $player->id,
            'event_type' => $payload['event'],
            'data' => [
                'user_ftd_value' => $payload['user_ftd_value'] ?? null,
                'user_ftd_date' => $payload['user_ftd_date'] ?? null,
                'payout' => $payload['payout'] ?? null,
            ],
        ]);

        //envia o pixel para o facebook atraves do job
        WebhookProcessor::dispatch($webhookEvent);

        return response()->json(['status' => 'success']);
    }

    public function test(Pixel $pixel)
    {
        Log::info("message");
        dd($pixel);
        return response()->json(['status' => 'success']);
    }
}