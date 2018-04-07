@extends('layouts.app')
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
</head>
@section('content')
    <div class="container">
        @if (\Session::get('locale') == 'ru')
            <h1>Частозадаваемые вопросы</h1>
        @foreach($result_ru as $value)
            <div class="topic">
                <div class="open">
                    <h2 class="question">{{"$value->question"}}</h2>
                    <span class="faq-t"></span>
                </div>
                <p class="answer">{{"$value->answer"}}</p>
            </div>
        @endforeach
        @else
            <h1>Frequently Asked Questions</h1>
            @foreach($result_en as $value)
                <div class="topic">
                    <div class="open">
                        <h2 class="question">{{"$value->question"}}</h2>
                        <span class="faq-t"></span>
                    </div>
                    <p class="answer">{{"$value->answer"}}</p>
                </div>
            @endforeach
        @endif
        <div class="topic">
            <div class="open">
                @if (\Session::get('locale') == 'ru')
                    <h2 class="question">Как привязать мой аккаунт на сайте к аккаунту telegram?</h2>
                    <span class="faq-t"></span>
            </div>
            <p class="answer">Зайдите в telegram бота <a href="https://t.me/cruim_bot" target="_blank">@cruim_bot</a> и
                нажмите на кнопу "Привязать аккаунт". После чего бот пришлет Вам ссылку, перейдя по которой
            произойдет привязка аккаунта. После чего Вы сможете получать сообщения от бота в telegram.</p>
            @else
                <h2 class="question">How can I bind app with telegram bot?</h2>
                <span class="faq-t"></span>
        </div>
        <p class="answer">Go to the telegram bot <a href="https://t.me/cruim_bot" target="_blank">@cruim_bot</a> and
            click on button "Bind account".</p>
        @endif
    </div>
    </div>
    <link rel="stylesheet" href="{{asset('css/faq.css')}}">
    <script type='text/javascript' src="{{asset('js/faq.js')}}"></script>
@endsection