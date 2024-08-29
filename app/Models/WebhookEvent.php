<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    use HasFactory;

    const EVENT_TYPE_LEAD = 1;
    const EVENT_TYPE_FTD = 2;
    const EVENT_TYPE_REDEPOSIT = 3;

    protected $fillable = [
        'player_id',
        'event_type',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
    

    public function player()
    {
        return $this->belongsTo(Player::class)->with('params');
    }
}

/*
    1 - lead
    2 - ftd
    3 - redeposito
*/