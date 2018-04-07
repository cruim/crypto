<?php

namespace App\Http\Controllers;

use App\Model\Abonents;
use App\Model\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    function index()
    {
        $result_en = Faq::select("question","answer")
            ->where("language","=","en")
            ->get();

        $result_ru = Faq::select("question","answer")
            ->where("language","=","ru")
            ->get();

        return view('faq', [
            'result_en' => $result_en,
            'result_ru' => $result_ru
        ]);
    }

    function sendHelpMessage($chatid)
    {
        $language = Abonents::select("language")
            ->where("telegram_id","=",$chatid)
            ->get();
        $language = $language[0]->language;

        if($language == 'ru')
        {
            $text = 'ℹ Если хотите использовать весь' . chr(10).
                'функционал веб-приложения,' . chr(10).
                'пожалуйста зарегистрируйтесь' . chr(10) .
                'на сайте https://cru.im/' .chr(10) .
                'После регистрации нажмите' . chr(10) .
                'в боте "Привязать аккаунт".' . chr(10) .
                'Более подробно https://cru.im/faq';
        }
        else
        {
            $text = 'ℹ If you want to use all' . chr(10).
                'web application functionality,' . chr(10).
                'please register' . chr(10) .
                'on the site https://cru.im/' .chr(10) .
                'After registration, click' . chr(10) .
                'in the bot "Bind account".' . chr(10) .
                'In details https://cru.im/faq';
        }

        $send_message = new SendMessageController();
        $send_message->sendMessage($chatid,$text,'cruim');
    }
}
