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
        'manager_id',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function pixel()
    {
        return $this->hasOne(Pixel::class);
    }

    public function commission()
    {
        return $this->hasOne(AffiliateCommission::class);
    }
}
