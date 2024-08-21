<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pixel extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public const TYPE_FACEBOOK = 1;
}
