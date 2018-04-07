<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="fe8007a8b1a17cab"/>
    <meta name="google-site-verification" content="dHQGPI_pYcF3cYMr1mUh8P76C6_6ZOI7CUr_TIaoXdg"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ asset ('img/favicon.ico') }}" type="image/x-icon">
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <!-- Styles -->
    {{--<link rel="stylesheet" href="{{asset('css/main.css')}}">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- JavaScripts -->
    <!--JQuery-->
    <script src="https://code.jquery.com/jquery-3.1.1.js"
            integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
    <!--jquery-ui-->
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>--}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-clockpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.numpad.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>
    <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.ru.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-clockpicker.min.js')}}"></script>


</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if (Auth::check())
                <ul class="nav navbar-nav shadow">
                    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i></a></li>
                </ul>
                @if (\Session::get('locale') == 'ru')
                    <ul class="nav navbar-nav shadow">
                        <li><a href="{{ url('/scheduller') }}">Планировщик</a></li>
                    </ul>
                    <ul class="nav navbar-nav shadow">
                        <li><a href="{{ url('/target') }}">Целевая Цена</a></li>
                    </ul>
                    <ul class="nav navbar-nav shadow">
                        <li><a href="{{ url('/faq') }}">FAQ</a></li>
                    </ul>
                @else
                    <ul class="nav navbar-nav shadow">
                        <li><a href="{{ url('/scheduller') }}">Scheduller</a></li>
                    </ul>
                    <ul class="nav navbar-nav shadow">
                        <li><a href="{{ url('/target') }}">TargetPrice</a></li>
                    </ul>
                    <ul class="nav navbar-nav shadow">
                        <li><a href="{{ url('/faq') }}">FAQ</a></li>
                    </ul>
                @endif
            @else
                <ul class="nav navbar-nav shadow">
                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                </ul>
        @endif

        <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::check())

                    <li><a href="http://t.me/cruim_bot" target="_blank" title="@cruim_bot">
                            <i class="fa fa-telegram telegram_nav"></i></a>
                    </li>
                    <li class="selectpicker_lang">
                        <select class="selectpicker1" data-width="fit">
                            @if (\Session::get('locale') == 'ru')
                                <option value="en" data-content='<span class="flag-icon flag-icon-us"></span>'
                                ></option>
                                <option value="ru" data-content='<span class="flag-icon flag-icon-ru"></span>'
                                        selected></option>
                            @else
                                <option value="en" data-content='<span class="flag-icon flag-icon-us"></span>'
                                        selected></option>
                                <option value="ru" data-content='<span class="flag-icon flag-icon-ru"></span>'
                                ></option>
                            @endif
                        </select>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if (\Session::get('locale') == 'ru')
                                <li><a href="{{ url('/profile') }}"><i class="glyphicon glyphicon-user"></i> Профиль</a>
                                </li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Выйти</a>
                                </li>
                            @else
                                <li><a href="{{ url('/profile') }}"><i class="glyphicon glyphicon-user"></i> Profile</a>
                                </li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @else
                    <li><a href="http://t.me/cruim_bot" target="_blank"><i class="fa fa-telegram telegram_nav"></i></a></li>
                    <li class="selectpicker_lang">
                        <select class="selectpicker1" data-width="fit">
                            @if (\Session::get('locale') == 'ru')
                                <option value="en" data-content='<span class="flag-icon flag-icon-us"></span>'
                                ></option>
                                <option value="ru" data-content='<span class="flag-icon flag-icon-ru"></span>'
                                        selected></option>
                            @else
                                <option value="en" data-content='<span class="flag-icon flag-icon-us"></span>'
                                        selected></option>
                                <option value="ru" data-content='<span class="flag-icon flag-icon-ru"></span>'
                                ></option>
                            @endif
                        </select>
                    </li>
                    @if (\Session::get('locale') == 'ru')
                    <li><a href="{{ url('/login') }}"><i class="fa fa-btn fa-sign-in"></i>Войти</a></li>
                    <li><a href="{{ url('/register') }}"><i class="fa fa-btn fa-user-plus"></i>Регистрация</a></li>
                    @else
                    <li><a href="{{ url('/login') }}"><i class="fa fa-btn fa-sign-in"></i>Login</a></li>
                    <li><a href="{{ url('/register') }}"><i class="fa fa-btn fa-user-plus"></i>Signup</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>
@yield('content')

<div id="footer">

    <div class="container">
        <span class="hidden-phone"
              style="text-align: right; float: right">
                <a href="http://t.me/cruim_bot" target="_blank" title="@cruim_bot">
                    <i class="fa fa-telegram telegram_nav"></i></a></span></p>
    </div>
</div>
{{--<div class="clr"></div>--}}
{{--<footer>Подвал</footer>--}}
</body>
<script src="{{asset('js/language.js')}}"></script>
</html>
