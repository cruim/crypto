<?php

namespace App\Http\Controllers;

use App\Model\TargetPrice;
use App\Model\Tokens;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class TargetPriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $user_id = Auth::user()->id;

        $result = TargetPrice::select(DB::raw("tokens.name, tokens.code, current_price, 
        target_price, target_price.active, target_price.id, target_price.cross_currency"))
            ->join("telegram.tokens", "target_price.token_id", "=", "tokens.id")
            ->join("telegram.users", "target_price.user_id", "=", "users.id")
            ->where("users.id", "=", "$user_id")
            ->get();

        $tokens = Tokens::select("name")
            ->where("currency", "=", "usd")
            ->orderByRaw('FIELD(name, "Bitcoin", "Ethereum", "Ripple","Bitcoin Cash","Litecoin","Stellar",
            "EOS","Monero","Dash","Ethereum Classic","Zcash","Tether","Augur","Gnosis")')
            ->get();

        $check_count = TargetPrice::select(DB::raw("count(*) as count"))
            ->where("user_id", "=", $user_id)
            ->get();
        $check_count = $check_count[0]->count;

        $cross_currency = Tokens::select(DB::raw("distinct currency"))->get();

        return view('target_price', [
            'result' => $result,
            'tokens' => $tokens,
            'record_count' => $check_count,
            'cross_currency' => $cross_currency
        ]);
    }

    function createStartTargetPriceList()
    {
        $date = date('Y-m-d');
        $user_id = User::select(DB::raw("max(id) as id"))->get();
        $user_id = $user_id[0]->id + 1;

        Db::insert("insert into telegram.target_price(token_id,user_id,created_at) 
        select id, $user_id, '$date'  from telegram.tokens where id in(1,2,3,11,14)");

        $result = Tokens::select("id", "url")
            ->whereIn("id", [1, 2, 3, 11, 14])
            ->get();

        foreach ($result as $value)
        {
            $current_price = $this->getCurrentPrice($value->url,'usd');
            $token_id = $value->id;

            DB::table('target_price')
                ->where('user_id', $user_id)
                ->where('token_id', $token_id)
                ->update(['current_price' => $current_price]);
        }
    }

    function getCurrentPrice($url,$cross_currency)
    {
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
            return round($response->result->price->last, 2);
        }
        else
        {
            return round($response->result->price->last, 8);
        }
    }

    function updateRecordActive(Request $request)
    {
        $data = $request['request'];
        $id = $data['record_id'];

        $scheduller = TargetPrice::where('id', $id)->first();

        if ($scheduller->active == 0)
        {
            TargetPrice::where("id", "=", $id)
                ->update(["active" => 1]);
        } else
        {
            TargetPrice::where("id", "=", $id)
                ->update(["active" => 0]);
        }
    }

    function deleteRecord($id)
    {
        DB::table('telegram.target_price')->where('id', '=', $id)->delete();
        return redirect()->to('/target');
    }

    function addRecord($token_name, $cross_currency)
    {
        $date = date('Y-m-d');
        $user_id = Auth::user()->id;

        Db::insert("insert into telegram.target_price(token_id,user_id,created_at,cross_currency)
        select id, $user_id, '$date', '$cross_currency'  from telegram.tokens where name = '$token_name'
        and currency = '$cross_currency'");

        $result = Tokens::select("url", "id")
            ->where("name", "=", $token_name)
            ->where("currency","=",$cross_currency)
            ->get();
        $current_price = $this->getCurrentPrice($result[0]->url,$cross_currency);
        $token_id = $result[0]->id;

        DB::table('target_price')
            ->where('user_id', $user_id)
            ->where('token_id', $token_id)
            ->update(['current_price' => $current_price]);

        return redirect()->to('/target');
    }

    function targetPriceMessageDistribution()
    {
        $result = TargetPrice::select("users.telegram_id", "tokens.url", "tokens.name", "current_price",
            "target_price", "target_price.id", "target_price.cross_currency")
            ->join("telegram.users", "target_price.user_id", "=", "users.id")
            ->join("telegram.tokens", "target_price.token_id", "=", "tokens.id")
            ->where("target_price.active", "=", 1)
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
                    $url = $value->url;
                    $current_price = $value->current_price;
                    $target_price = $value->target_price;
                    $id = $value->id;
                    $cross_currency = $value->cross_currency;
                    try{
                        $check_price = $this->getCurrentPrice($url,$cross_currency);
                    }
                    catch (\Exception $e)
                    {
                        $send_message = new SendMessageController();
                        $send_message->sendMessage(env('TELEGRAM_ADMIN_ID'), 'TargetPrice1: ' . $e->getMessage(), 'cruim');
                    }


                    if ($check_price !=0 and (($current_price > $target_price and $target_price >= $check_price) or
                            ($current_price < $target_price and $target_price <= $check_price))
                    )
                    {
                        if ($cross_currency == 'usd')
                        {
                            $message = $name . ' ' . chr(10) .
                                'Target Price: ' . $check_price . chr(36);
                        } else
                        {
                            $message = $name . ' ' . chr(10) .
                                'Target Price: ' . $check_price . ' ₿';
                        }

                        $send_message = new SendMessageController();
                        $send_message->sendMessage($telegram_id, $message, 'cruim');

                        TargetPrice::where("id", "=", $id)
                            ->update(["active" => 0]);
                    }
                } catch (\Exception $e)
                {
                    $send_message = new SendMessageController();
                    $send_message->sendMessage(env('TELEGRAM_ADMIN_ID'), 'TargetPrice: ' . $e->getMessage(), 'cruim');
                }
            }
            return 1;
        }
    }

    function updatePrice(Request $request)
    {
        $data = $request['request'];
        $column = $data['column'];
        $id = $data['record_id'];
        $value = $data['value'];

        TargetPrice::where("id", "=", $id)
            ->update(["$column" => $value]);
    }

    function updateCurrentPrice(Request $request)
    {
        $data = $request['request'];
        $id = $data['record_id'];

        $token_id = TargetPrice::select("token_id","cross_currency")
            ->where("id", "=", $id)
            ->get();

        $url = Tokens::select("url")
            ->where("id", "=", $token_id[0]->token_id)
            ->get();
        $url = $url[0]->url;

        $current_price = $this->getCurrentPrice($url,$token_id[0]->cross_currency);

        TargetPrice::where("id", "=", $id)
            ->update(["current_price" => $current_price]);

        return $current_price;
    }
}
