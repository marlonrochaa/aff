<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'deposit_count',
        'deposit_amount',
        'withdrawal_count',
        'withdrawal_amount',
    ];
}
