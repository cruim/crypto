<?php

namespace App\Http\Controllers;

use App\Model\Abonents;
use App\Model\Tokens;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class KeyboardController extends Controller
{
    function buildUsdTokenKeyboard($chatid, $bot_name)
    {
        $cross_currency = Abonents::select("cross_currency")
            ->where("telegram_id","=",$chatid)
            ->get();

        $cross_currency = $cross_currency[0]->cross_currency;

        $available_buttons = Tokens::select("name")
            ->where("currency", "=", $cross_currency)
            ->orderByRaw('FIELD(name, "Bitcoin", "Ethereum", "Ripple","Bitcoin Cash","Litecoin","Stellar",
            "EOS","Monero","Dash","Ethereum Classic","Zcash","Tether","Augur","Gnosis")')
            ->get();

        $keyboard = array();
        foreach ($available_buttons as $value)
        {
            $keyboard[] = array((string)$value->name);
        }

        $reply_markup = \Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
        ]);
        $keyboard = new KeyboardController();
        $keyboard->inlineKeyboard($chatid, $bot_name);

        $send_messge = new SendMessageController();
        $send_messge->sendMessage($chatid, 'Available Tokens', $bot_name, $reply_markup);

        return response()->json(['success' => true]);
    }

    function getTelegramId($chatid, $bot_name)
    {
        $text = "Your telegram id: " . $chatid . chr(10) .
            "Follow the link " . chr(10) .
            "https://cru.im/settelegramid/" . $chatid;

        $send_messge = new SendMessageController();
        $send_messge->sendMessage($chatid, $text, $bot_name);

        return response()->json(['success' => true]);
    }

    function inlineKeyboard($chatid, $bot_name)
    {
        $language = Abonents::select("language")
            ->where("telegram_id", "=", $chatid)
            ->get();

        $language = $language[0]->language;

        try
        {
            if ($language == 'en')
            {
                $reply_markup = Keyboard::make()
                    ->inline()
                    ->row(Keyboard::inlineButton(['text' => '🔗 Go to site', 'url' => 'https://cru.im']))
                    ->row(Keyboard::inlineButton(['text' => '🖇 Bind account', 'callback_data' => 'Bind account']))
                    ->row(Keyboard::inlineButton(['text' => '🌐 Select language', 'callback_data' => 'Select language']))
                    ->row(Keyboard::inlineButton(['text' => '💱 Cross-currency', 'callback_data' => 'Cross-currency']))
                    ->row(Keyboard::inlineButton(['text' => 'ℹ About', 'callback_data' => 'help']));
                $send_messge = new SendMessageController();
                $send_messge->sendMessage($chatid, '⚙ Help ', $bot_name, $reply_markup);
            } else
            {
                $reply_markup = Keyboard::make()
                    ->inline()
                    ->row(Keyboard::inlineButton(['text' => '🔗 На сайт', 'url' => 'https://cru.im']))
                    ->row(Keyboard::inlineButton(['text' => '🖇 Привязать аккаунт', 'callback_data' => 'Bind account']))
                    ->row(Keyboard::inlineButton(['text' => '🌐 Выбрать язык', 'callback_data' => 'Select language']))
                    ->row(Keyboard::inlineButton(['text' => '💱 Кросс-валюта', 'callback_data' => 'Cross-currency']))
                    ->row(Keyboard::inlineButton(['text' => 'ℹ About', 'callback_data' => 'help']));
                $send_messge = new SendMessageController();
                $send_messge->sendMessage($chatid, '⚙ Помощь ', $bot_name, $reply_markup);
            }

        } catch (\Exception $e)
        {
            $send_messge = new SendMessageController();
            $send_messge->sendMessage(348169607, $e->getMessage(), $bot_name);
        }

        return response()->json(['success' => true]);
    }

    function selectLanguage($chatid, $bot_name)
    {
        $language = Abonents::select("language")
            ->where("telegram_id", "=", $chatid)
            ->get();

        $language = $language[0]->language;
        if ($language == 'en')
        {
            $reply_markup = Keyboard::make()
                ->inline()
                ->row(Keyboard::inlineButton(['text' => '🇷🇺 Русский', 'callback_data' => 'ru']),
                    Keyboard::inlineButton(['text' => '🇬🇧 English', 'callback_data' => 'en']));
            $send_messge = new SendMessageController();
            $send_messge->sendMessage($chatid, '🌐 Select language ', $bot_name, $reply_markup);

        } else
        {
            $reply_markup = Keyboard::make()
                ->inline()
                ->row(Keyboard::inlineButton(['text' => '🇷🇺 Русский', 'callback_data' => 'ru']),
                    Keyboard::inlineButton(['text' => '🇬🇧 English', 'callback_data' => 'en']));
            $send_messge = new SendMessageController();
            $send_messge->sendMessage($chatid, '🌐 Выбрать язык ', $bot_name, $reply_markup);
        }
    }

    function selectCrossCurrency($chatid, $bot_name)
    {
        $language = Abonents::select("language")
            ->where("telegram_id", "=", $chatid)
            ->get();

        $language = $language[0]->language;

        if ($language == 'en')
        {
            $reply_markup = Keyboard::make()
                ->inline()
                ->row(Keyboard::inlineButton(['text' => '💵 USD', 'callback_data' => 'usd']),
                    Keyboard::inlineButton(['text' => '₿ BTC', 'callback_data' => 'btc']));
            $send_messge = new SendMessageController();
            $send_messge->sendMessage($chatid, '💱 Cross-currency ', $bot_name, $reply_markup);
        } else
        {
            $reply_markup = Keyboard::make()
                ->inline()
                ->row(Keyboard::inlineButton(['text' => '💵 USD', 'callback_data' => 'usd']),
                    Keyboard::inlineButton(['text' => '₿ BTC', 'callback_data' => 'btc']));
            $send_messge = new SendMessageController();
            $send_messge->sendMessage($chatid, '💱 Кросс-валюта ', $bot_name, $reply_markup);
        }
    }
}
