<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\BotsManager;

class SendMessageController extends Controller
{
    function sendMessage($chatid, $response_text, $bot_name, $reply_markup = null)
    {
        try
        {
            $config = new ConfigController();
            $config = $config->getConfig();
            $bot_manager = new BotsManager((array)$config);
            for ($start = 0, $length = 2500; $subtext = mb_substr($response_text, $start, $length); $start = $start + 2500)
            {
                $bot_manager->bot($bot_name)->sendMessage([
                    'chat_id' => $chatid,
                    'text' => $subtext,
                    'reply_markup' => $reply_markup,
                    'parse_mode' => 'Markdown'
                ]);
            }

        } catch (\Exception $e)
        {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => true]);
    }
}
