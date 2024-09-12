<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'external_id',
        'profile_id',
        'balance',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function commission()
    {
        return $this->hasOne(AffiliateCommission::class);
    }
}
