<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'email',
        'phone',
    ];

    public function params()
    {
        //pega o utlima parametro adicionado ao player
        return $this->hasMany(Param::class)->latest();
    }
}
