<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\AbonentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\KeyboardController;
use App\Http\Controllers\SendMessageController;
use App\Http\Controllers\TelegramLogController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Api;
use Telegram;

class CruimBotController extends Controller
{
    function setWebHook(Request $request)
    {
        try
        {
            if (isset($request['callback_query']))
            {
                $id = $request['callback_query']['id'];
                $text = $request['callback_query']['data'];
                $chatid = $request['callback_query']['message']['chat']['id'];
                $bot_name = 'cruim';
            } else
            {
                $text = (string)$request['message']['text'];
                $chatid = $request['message']['chat']['id'];
                $bot_name = 'cruim';
                $id = 0;
            }

            $check_abonent = new AbonentController();
            $check_abonent->checkIsAbonentExist($chatid);

            $telegram_log = new TelegramLogController();
            $telegram_log->writeTextMessageFromAbonent($chatid, $text);
            if (in_array($text,['/start','start','Start','/Start','START','sTART']))
            {
                $keyboard = new KeyboardController();
                $keyboard->buildUsdTokenKeyboard($chatid, $bot_name);
            } elseif ($text == 'Bind account')
            {
                $keyboard = new KeyboardController();
                $keyboard->getTelegramId($chatid, $bot_name);
                return response()->json(['success' => true]);
            } elseif ($text == 'Select language')
            {
                $keyboard = new KeyboardController();
                $keyboard->selectLanguage($chatid, $bot_name);

            } elseif ($text == 'ru' || $text == 'en')
            {
                $change_language = new AbonentController();
                $change_language->updateAbonentLanguage($chatid, $text);
                $keyboard = new KeyboardController();
                $keyboard->buildUsdTokenKeyboard($chatid, $bot_name);
            } elseif ($text == 'Cross-currency')
            {
                $keyboard = new KeyboardController();
                $keyboard->selectCrossCurrency($chatid, $bot_name);
            } elseif ($text == 'usd' || $text == 'btc')
            {
                $change_cross_currency = new AbonentController();
                $change_cross_currency->updateAbonentCrossCurrency($chatid,$text);
                $keyboard = new KeyboardController();
                $keyboard->buildUsdTokenKeyboard($chatid, $bot_name);
            } elseif (in_array($text,['/wiki','/help','HELP','help','wiki','WIKI','wIKI','hELP','помощь','Помощь','вики','Вики']))
            {
                $help_message = new FaqController();
                $help_message->sendHelpMessage($chatid);
            }
            else
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
