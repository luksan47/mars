<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ env('LOGO','') }}">

    <title>{{ config('app.name', 'Urán') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.css') }}" media="screen,projection" />
    <style>
    html,
    body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 90vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links>a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
    </style>
</head>

<body>
    @if (Route::has('login'))
    <header>
        <div class="navbar-fixed">
            <nav class="top-nav">
                <div class="nav-wrapper">
                    <div class="row">
                        <ul class="right">
                            @auth
                            <li><a href="{{ url('/home') }}">@lang('general.login')</a></li>
                            @else
                            <li><a href="{{ route('login') }}">@lang('general.login')</a></li>

                            @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">@lang('general.register')
                                    <span class="hide-on-small-only">@lang('general.register_collegist')</span></a></li>
                            <li class="hide-on-small-only"><a href="{{ route('register.guest') }}">@lang('general.register')
                                    @lang('general.register_guest')</a></li>
                            @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    @endif
    </header>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="row">
                <div class="col s12 l2 offset-l2 center-align">
                    <img class="material-icons" style="height:130px" src="{{ env('LOGO','') }}">
                </div>
                <div class="col s12 l5 center-align">
                    <div class="noselect"
                        style="text-indent:15px;font-size:80px;text-transform: uppercase;font-weight:300;letter-spacing:3px;">
                        {{ config('app.name', 'Urán') }} </div>
                </div>
            </div>

            <div class="links">
                <a href="#">
                    @lang('main.better')</a><br class="mobile-break" />
                <a href="#">
                    @lang('main.faster')</a><br class="mobile-break" />
                <a href="#">
                    @lang('main.brilliant')</a><br class="mobile-break" />
                <a href="#">
                    @lang('main.essential')</a><br class="mobile-break" />
                <a href="#">
                    @lang('main.modern')</a><br class="mobile-break" />
                <a href="https://github.com/luksan47/mars">
                    @lang('main.open')</a><br class="mobile-break" />
            </div>
        </div>
    </div>
</body>

</html>