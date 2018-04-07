<?php

namespace App\Http\Controllers;

use App\Model\Tokens;
use App\User;
use DB;
use App\Model\Scheduller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchedullerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $result = Scheduller::select(DB::raw("tokens.name, tokens.code, DATE_FORMAT(sending_time,'%H:%i') as sending_time, 
        active, scheduller.id, scheduller.cross_currency"))
            ->join("telegram.tokens", "scheduller.token_id", "=", "tokens.id")
            ->join("telegram.users", "scheduller.user_id", "=", "users.id")
            ->where("users.id", "=", "$user_id")
            ->get();

        $tokens = Tokens::select("name")
            ->where("currency", "=", "usd")
            ->orderByRaw('FIELD(name, "Bitcoin", "Ethereum", "Ripple","Bitcoin Cash","Litecoin","Stellar",
            "EOS","Monero","Dash","Ethereum Classic","Zcash","Tether","Augur","Gnosis")')
            ->get();

        $check_count = Scheduller::select(DB::raw("count(*) as count"))
            ->where("user_id", "=", $user_id)
            ->get();
        $check_count = $check_count[0]->count;

        $cross_currency = Tokens::select(DB::raw("distinct currency"))->get();

        return view('scheduller', [
            'result' => $result,
            'tokens' => $tokens,
            'record_count' => $check_count,
            'cross_currency' => $cross_currency
        ]);
    }

    function updateRecordactive(Request $request)
    {
        $data = $request['request'];
        $id = $data['record_id'];

        $scheduller = Scheduller::where('id', $id)->first();

        if ($scheduller->active == 0)
        {
            Scheduller::where("id", "=", $id)
                ->update(["active" => 1]);
        } else
        {
            Scheduller::where("id", "=", $id)
                ->update(["active" => 0]);
        }
    }

    function updateRecordTime(Request $request)
    {
        $data = $request['request'];
        $id = $data['record_id'];

        Scheduller::where("id", "=", $id)
            ->update(["sending_time" => $data['value']]);
    }

    function deleteRecord($id)
    {
        DB::table('telegram.scheduller')->where('id', '=', $id)->delete();
        return redirect()->to('/scheduller');
    }

    function addRecord($token_name,$cross_currency)
    {
        $date = date('Y-m-d');
        $user_id = Auth::user()->id;

        Db::insert("insert into telegram.scheduller(token_id,user_id,created_at,cross_currency) 
        select id, $user_id, '$date', '$cross_currency' from telegram.tokens where name = '$token_name' 
        and tokens.currency = '$cross_currency'");
        return redirect()->to('/scheduller');
    }

    function createStartSchedullerList()
    {
        $date = date('Y-m-d');
        $user_id = User::select(DB::raw("max(id) as id"))->get();
        $user_id = $user_id[0]->id + 1;

        Db::insert("insert into telegram.scheduller(token_id,user_id,created_at) 
        select id, $user_id, '$date'  from telegram.tokens where id in(1,2,3,11,14)");
    }

    function schedullerMessageDistribution()
    {
        $cur_time = date('H:i');

        $result = Scheduller::select("users.telegram_id", "tokens.name", "scheduller.cross_currency")
            ->join("telegram.users", "scheduller.user_id", "=", "users.id")
            ->join("telegram.tokens", "scheduller.token_id", "=", "tokens.id")
            ->whereRaw("sending_time = TIME('$cur_time')")
            ->where("scheduller.active", "=", 1)
            ->where("users.telegram_id", "<>", 0)
            ->get();

        if (count($result) > 0)
        {
            foreach ($result as $value)
            {
                try
                {
                    $telegram_id = $value->telegram_id;
                    $name = $value->name;
                    $cross_currency = $value->cross_currency;

                    $token_data = new TokenController();
                    $token_data->getSchedullerTokenData($telegram_id, 'cruim', $name, $cross_currency);
                } catch (\Exception $e)
                {
                    $send_message = new SendMessageController();
                    $send_message->sendMessage(env('TELEGRAM_ADMIN_ID'), 'Scheduller: ' . $e->getMessage(), 'cruim');
                }
            }
            return response()->json(['success' => true]);
        }
    }
}
