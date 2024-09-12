<?php

namespace App\Console\Commands;

use App\Models\Affiliate;
use App\Models\Manager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncAffiliate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-affiliate';

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
        Log::info("RODOU O CRON do sync-affiliate");
        
        $response = Http::withHeaders([
            'Authorization' => env('API_KEY'),
        ])->get(env('API_URL') . '/af2_aff_op?filter={%22aff_status_id%22%3A2}');

        //pega response da api
        $affiliates = $response->json();

        foreach ($affiliates as $affiliate) {
            $manager = Manager::firstOrCreate(
                [
                    'external_id' => $affiliate['manager_id'],
                ],
                [
                    'name' => $affiliate['manager_contacts']['first_name'] . ' ' . $affiliate['manager_contacts']['last_name'],
                    'email' => $affiliate['manager_contacts']['email'],
                ]
            );

            Affiliate::updateOrCreate(
                [
                    'external_id' => $affiliate['id'],
                ],
                [
                    'name' => $affiliate['affiliate_name'],
                    'email' => $affiliate['bo_user_email'],
                    'external_id' => $affiliate['id'],
                    'profile_id' => 1,
                    'balance' => $affiliate['balance'],
                    'manager_id' => $manager->id ?? null,
                ]
            );
        }
    }
}