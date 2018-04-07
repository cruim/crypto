<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailTelegramConfirm extends Model
{
    public $fillable = ['email', 'token', 'telegram_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    public static function createForEmail($email)
    {
        return self::create([
            'email' => $email,
            'token' => str_random(20)
        ]);
    }

    public static function sendEmail()
    {
//        $auth = new Auth();
//        $auth->validate($request, ['email' => 'required|email|exists:users']);

        $emailLogin = self::createForEmail('hedgehog147@gmail.com');

        $url = route('auth.email-authenticate', [
            'token' => $emailLogin->token
        ]);

        Mail::send('auth.emails.email-login', ['url' => $url], function ($m)  {
            $m->from('noreply@myapp.com', 'MyApp');
            $m->to(('hedgehog147@gmail.com'))->subject('MyApp Login');
        });
    }

    public static function validFromToken($token)
    {
        return self::where('token', $token)
            ->where('created_at', '>', Carbon::parse('-15 minutes'))
            ->firstOrFail();
    }
}
