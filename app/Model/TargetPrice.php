<?php
/**
 * Created by PhpStorm.
 * User: Пользователь
 * Date: 18.02.2018
 * Time: 16:16
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class TargetPrice extends Model
{
    protected $table = 'telegram.target_price';
    protected $fillable =
        [
            'id',
            'token_id',
            'user_id',
            'current_price',
            'target_price',
            'active',
            'cross_currency'
        ];
}