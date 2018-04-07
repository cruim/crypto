<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function getConfig()
    {
        return [

            'default' => 'cruim',


            'bots' => [
                'common' => [
                    'username' => 'MyTelegramBot',
                    'token' => '304869753:AAGgSs9qeYTdXs8vYRKHs3AL-Vvn0NvVbno',
                    'commands' => [
                    ],
                ],
                'cruim' => [
                    'username' => 'MyTelegramBotCruim',
                    'token' => '462050576:AAGWg4Ho7nYLU0MyGp1ddgrnPaU56NzhP6Y',
                    'commands' => [
                    ],
                ],
            ],];
    }

    function sitemap()
    {
        return view('sitemap');
    }
}
