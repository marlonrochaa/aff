<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pixel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'affiliate_id',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public const TYPE_FACEBOOK = 1;

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}