<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Abonents extends Model
{
    protected $table = 'telegram.abonents';
    protected $fillable =
        [
            'id',
            'telegram_id',
            'active',
            'language',
            'cross_currency'
        ];
}
