<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BindController extends Controller
{
    function updateTelegramId($telegram_id)
    {
        try{
            $user_id = \Auth::user()->id;
        }catch (\Exception $e)
        {
            $user_id = 0;
        }

        if($user_id == 0)
        {
            return redirect()->to('/bind_account');
        }

        User::where("id", "=", $user_id)
            ->update(["telegram_id" => $telegram_id]);

        $send_message = new SendMessageController();
        $send_message->sendMessage($telegram_id,'You have successfully linked your account','cruim');

        return redirect()->to('/');
    }

    function failedBind()
    {
        return view('bind_account');
    }
}
