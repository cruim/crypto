<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $user_id = Auth::user()->id;

        $result = User::select("name","email")
            ->where("id","=",$user_id)
            ->get();

        return view('contact',[
            'result' => $result
        ]);
    }
}
