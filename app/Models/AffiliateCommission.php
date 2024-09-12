<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'dt',
        'visit_count',
        'registration_count',
        'qftd_count',
        'qlead_count',
        'deposit_count',
        'deposit_total',
        'net_pl',
        'netwin',
        'pl',
        'ftd_count',
        'ftd_total',
        'bonus_amount',
        'withdrawal_count',
        'withdrawal_total',
        'chargback_total',
        'operations',
        'volume',
    ];
}
