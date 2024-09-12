<?php

namespace App\Console\Commands;

use App\Models\Affiliate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-commission';

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
        $affiliates = Affiliate::all();

        foreach($affiliates as $affiliate) {
            $response = Http::withHeaders([
                'Authorization' => env('API_KEY'),
            ])->get(env('API_URL') . '/af2_media_report_op?aggregation_period=DAY&affiliate_id=' . $affiliate->external_id);

            $value = $response->json();

            if(!isset($value['data'])) {
                continue;
            }

            foreach($value['data'] as $commission) {
                $date = date('Y-m-d', strtotime($commission['dt']));
                $affiliate->commission()->updateOrCreate(
                    ['dt' => $date],
                    [
                        'visit_count' => $commission['visit_count'],
                        'registration_count' => $commission['registration_count'],
                        'qftd_count' => $commission['qftd_count'],
                        'qlead_count' => $commission['qlead_count'],
                        'deposit_count' => $commission['deposit_count'],
                        'deposit_total' => $commission['deposit_total'],
                        'net_pl' => $commission['net_pl'],
                        'netwin' => $commission['netwin'],
                        'pl' => $commission['pl'],
                        'ftd_count' => $commission['ftd_count'],
                        'ftd_total' => $commission['ftd_total'],
                        'bonus_amount' => $commission['bonus_amount'],
                        'withdrawal_count' => $commission['withdrawal_count'],
                        'withdrawal_total' => $commission['withdrawal_total'],
                        'chargback_total' => $commission['chargback_total'],
                        'operations' => $commission['operations'],
                        'volume' => $commission['volume'],
                        'commissions_cpl' => $commission['commissions_cpl'],
                        'commissions_cpa' => $commission['commissions_cpa'],
                        'commissions_rev_share' => $commission['commissions_rev_share'],
                        'deductions' => $commission['deductions'],
                        'sub_commission_from_child' => $commission['sub_commission_from_child'],
                        'adjustments' => $commission['adjustments'],
                        'payments' => $commission['payments'],
                        'conversion_rate' => $commission['conversion_rate'],
                        'net_deposit_total' => $commission['net_deposit_total'],
                        'commissions_total' => $commission['commissions_total'],
                        'balance' => $commission['balance'],
                    ]
                );
            }
        }
    }
}