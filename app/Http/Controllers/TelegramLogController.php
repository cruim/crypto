<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;

class TelegramLogController extends Controller
{
    function writeTextMessageFromAbonent($chatid, $text)
    {
        DB::table('incoming_message')->insert(
            ['telegram_id' => $chatid,
                'message' => $text]
        );
    }

    function writeTextMessageToAbonent($chatid, $text)
    {
        DB::table('outgoing_massage')->insert(
            ['telegram_id' => $chatid,
                'message' => $text]
        );
    }
}
