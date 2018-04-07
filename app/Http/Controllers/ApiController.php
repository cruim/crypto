<?php

namespace App\Http\Controllers;
use App\EmailTelegramConfirm;
use App\Model\Scheduller;
use App\Model\Tokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;

class ApiController extends Controller
{
    function me()
    {
//        $cur_date = date('Y-m-d H:i:s');
//        $url = "http://asterisk.api.crm.zdorov.top/?key=jsrBJUPvJThnqQ2P&event=groups&date=" . $cur_date;
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        $result = (curl_exec($curl));
//        curl_close($curl);

        return 1;

//        $test = "http://asterisk.api.crm.zdorov.top/?key=jsrBJUPvJThnqQ2P&event=groups&date=2017-03-26%2011:30:00";
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $test);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        $result = json_decode(curl_exec($curl));
//        curl_close($curl);
//        $text = '';
//        foreach ($result->response as $key => $value)
//        {
//            $text .= $key . ': ' .$value->name;
//
//                foreach ($value->members->telephony_ru as $key => $value)
//                {
//                    if($value == 0)
//                    {
//                        return json_encode($key . ' - ' . 'red') . $text;
//                    }
//                    else
//                    {
//                        return json_encode($key . ' - ' . 'green') . $text;
//                    }
//
//                }
//
//            exit();
//
//        }
////        echo $text;exit();
//        echo "<pre>";print_r((($result->response)));echo "</pre>";
//        print_r($result);
    }

    function setWebHook(Request $request)
    {
        try
        {
            $text = (string)$request['message']['text'];
            $chatid = $request['message']['chat']['id'];
            $bot_name = 'common';
            $telegram_log = new TelegramLogController();
            $telegram_log->writeTextMessageFromAbonent($chatid, $text);
            if ($text == '/start' or $text == 'start')
            {
                $keyboard = new KeyboardController();
                $keyboard->buildUsdTokenKeyboard($chatid, $bot_name);
            } else
            {
                $token = new TokenController();
                $token->getTokenData($chatid, $bot_name, $text);
            }
        } catch (\Exception $e)
        {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => true]);
    }
}
