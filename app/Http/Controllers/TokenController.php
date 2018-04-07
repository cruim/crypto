<?php

namespace App\Http\Controllers;

use App\Model\Abonents;
use App\Model\Tokens;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    function getTokenData($chatid, $bot_name, $text)
    {
        try
        {
            $cross_currency = Abonents::select("cross_currency")
                ->where("telegram_id", "=", $chatid)
                ->get();

            $cross_currency = $cross_currency[0]->cross_currency;

            $data = Tokens::select("url")
                ->where("name", "=", $text)
                ->where("currency", "=", $cross_currency)
                ->get();
            if (count($data) < 1)
            {
                return response()->json(['success' => true]);
            }
            $url = $data[0]->url;
            $ch = curl_init();
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            $curl_result = curl_exec($curl);
            $answer = $curl_result;
            $response = json_decode($answer);
            curl_close($ch);

            if($cross_currency == 'usd')
            {
                $message = $text . ' ' . chr(10) .
                    'current: ' . round($response->result->price->last, 2) . chr(36) . chr(10) .
                    'high: ' . round($response->result->price->high, 2) . chr(36) . chr(10) .
                    'low: ' . round($response->result->price->low, 2) . chr(36);
            }
            else
            {
                $message = $text . ' ' . chr(10) .
                    'current: ' . rtrim(number_format($response->result->price->last, 8, '.', ''),'0') . ' ₿' . chr(10) .
                    'high: ' . rtrim(number_format($response->result->price->high, 8, '.', ''),'0') . ' ₿' . chr(10) .
                    'low: ' . rtrim(number_format($response->result->price->low, 8, '.', ''),'0') . ' ₿';
            }


            $log = new TelegramLogController();
            $log->writeTextMessageToAbonent($chatid, $message);

            $keyboard = new KeyboardController();
            $keyboard->inlineKeyboard($chatid, $bot_name);

            $send_message = new SendMessageController();
            $send_message->sendMessage($chatid, $message, $bot_name);
        } catch (\Exception $e)
        {
            return response()->json(['success' => true]);
        }

    }

    function getSchedullerTokenData($chatid, $bot_name, $text, $cross_currency)
    {
        try
        {
            $data = Tokens::select("url")
                ->where("name", "=", $text)
                ->where("currency", "=", $cross_currency)
                ->get();
            if (count($data) < 1)
            {
                return response()->json(['success' => true]);
            }
            $url = $data[0]->url;
            $ch = curl_init();
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            $curl_result = curl_exec($curl);
            $answer = $curl_result;
            $response = json_decode($answer);
            curl_close($ch);

            if($cross_currency == 'usd')
            {
                $message = $text . ' ' . chr(10) .
                    'current: ' . round($response->result->price->last, 2) . chr(36) . chr(10) .
                    'high: ' . round($response->result->price->high, 2) . chr(36) . chr(10) .
                    'low: ' . round($response->result->price->low, 2) . chr(36);
            }
            else
            {
                $message = $text . ' ' . chr(10) .
                    'current: ' . rtrim(number_format($response->result->price->last, 8, '.', ''),'0') . ' ₿' . chr(10) .
                    'high: ' . rtrim(number_format($response->result->price->high, 8, '.', ''),'0') . ' ₿' . chr(10) .
                    'low: ' . rtrim(number_format($response->result->price->low, 8, '.', ''),'0') . ' ₿';
            }


            $log = new TelegramLogController();
            $log->writeTextMessageToAbonent($chatid, $message);

            $keyboard = new KeyboardController();
            $keyboard->inlineKeyboard($chatid, $bot_name);

            $send_message = new SendMessageController();
            $send_message->sendMessage($chatid, $message, $bot_name);
        } catch (\Exception $e)
        {
            return response()->json(['success' => true]);
        }
    }

}
