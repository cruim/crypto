<?php

namespace App\Http\Controllers;

use App\Model\Abonents;
use Illuminate\Http\Request;
use DB;

class AbonentController extends Controller
{
    function checkIsAbonentExist($chatid)
    {
        $check = Abonents::select("id")
            ->where("telegram_id", "=", $chatid)
            ->get();

        if (count($check) == 0)
        {
            DB::table('abonents')->insert(
                ['telegram_id' => $chatid]
            );
        }
    }

    function updateAbonentLanguage($chatid, $language)
    {
        DB::table('abonents')
            ->where('telegram_id', $chatid)
            ->update(['language' => $language]);
    }

    function updateAbonentCrossCurrency($chatid, $cross_currency)
    {
        DB::table('abonents')
            ->where('telegram_id', $chatid)
            ->update(['cross_currency' => $cross_currency]);
    }
}
