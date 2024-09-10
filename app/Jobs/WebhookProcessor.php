<?php

namespace App\Jobs;

use App\Models\Affiliate;
use App\Services\Pixels\FacebookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WebhookProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $webhookEvent;
    /**
     * Create a new job instance.
     */
    public function __construct($webhookEvent)
    {
        $this->webhookEvent = $webhookEvent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $eventName = '';

        if ($this->webhookEvent->player->params->isEmpty()) {
            return;
        }

        //verifica o utm_source se existe na tabela affiliates na coluna external_id 
        $affiliate = Affiliate::where('external_id', $this->webhookEvent->player->params->first()->parameters['utm_source'])->first();

        if(!$affiliate) { 
            return;
        }

        switch ($this->webhookEvent->event_type) {
            case 1:
                $eventName = 'betvoa_lead';
                break;
            case 2:
                $eventName = 'Ftd';
                break;
            case 3:
                $eventName = 'Redeposit';
                break;
        }
        $facebookService = new FacebookService($affiliate);

        $facebookService->sendPixel($eventName, $this->webhookEvent->player, $affiliate);
    }
}