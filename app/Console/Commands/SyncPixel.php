<?php

namespace App\Console\Commands;

use App\Services\Pixels\FacebookService;
use Illuminate\Console\Command;

class SyncPixel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-pixel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $total = 2;

        $this->output->progressStart($total);
        
        $this->sendPixel('TesteVoa', app(FacebookService::class));

        $this->output->progressAdvance();

        $this->output->progressFinish();

        $this->info('Pixel synced successfully.');
    }

    /**
     * Create a new command instance.
     */
    public function sendPixel(string $eventName, FacebookService $facebookService): void
    {
        //$facebookService->sendPixel($eventName);
        sleep(2);
    }
}