<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Scheduller extends Model
{
    protected $table = 'telegram.scheduller';
    protected $fillable =
        [
            'id',
            'token_id',
            'user_id',
            'sending_time',
            'active',
            'cross_currency'
        ];
}