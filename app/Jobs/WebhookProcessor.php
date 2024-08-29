<?php

namespace App\Jobs;

use App\Services\Pixels\FacebookService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WebhookProcessor implements ShouldQueue
{
    use Queueable;
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
    public function handle(FacebookService $facebookService): void
    {
        $eventName = '';

        if ($this->webhookEvent->player->params->isEmpty()) {
            return;
        }

        if($this->webhookEvent->player->params->first()->parameters['utm_source'] != '269578') {
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

        $facebookService->sendPixel($eventName, $this->webhookEvent->player);
    }
}