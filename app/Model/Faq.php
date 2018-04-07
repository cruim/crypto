<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'telegram.faq';
    protected $fillable =
        [
            'id',
            'question',
            'answer'
        ];
}
