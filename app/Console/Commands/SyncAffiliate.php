<?php

namespace App\Console\Commands;

use App\Models\Affiliate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        $response = Http::withHeaders([
            'Authorization' => env('API_KEY'),
        ])->get(env('API_URL') . '/af2_aff_op?filter={%22aff_status_id%22%3A2}');

        //pega response da api
        $affiliates = $response->json();

        foreach ($affiliates as $affiliate) {
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
                ]
            );
        }
    }
}