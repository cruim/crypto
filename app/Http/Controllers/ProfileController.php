<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $profile = User::where('id', $request->user()->id)->get();

        return view('profile', [
            'profile' => $profile,
        ]);
    }

    function updateUserInfo($id,$email,$telegram_id)
    {
        User::where("id", "=", $id)
            ->update(["email" => $email, "telegram_id" => $telegram_id]);

        return redirect()->to('/profile');
    }

    function changeAppLanguage(Request $request)
    {
        $data = $request['request'];
        $language = $data['language'];
        $user_id = \Auth::user()->id;
        Session::put('locale', $language);
        User::where("id", "=", $user_id)
            ->update(["language" => $language]);

        return 1;
    }

    function redirectBack()
    {
//        header("Location: {$_SERVER['HTTP_REFERER']}");
//        exit;
    }
}
