<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    protected $table = 'telegram.tokens';
    protected $fillable =
        [
            'id',
            'code',
            'name',
            'url',
            'currency'
        ];
}