<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
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

            .links > a {
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
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">@lang('general.login')</a>

                        @if (Route::has('register'))
                            <a class="mobile-break" href="{{ route('register') }}">@lang('general.register')</a>
                            <a class="pc-break" href="{{ route('register') }}">@lang('general.register') @lang('general.register_collegist')</a>
                            <a class="pc-break" href="{{ route('register.guest') }}">@lang('general.register') @lang('general.register_guest')</a>
                        @endif
                    @endauth

                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Urán 2.0
                </div>

                <div class="links">
                    <a href="">
                    @lang('main.better')</a><br class="mobile-break"/>
                    <a href="">
                    @lang('main.faster')</a><br class="mobile-break"/>
                    <a href="">
                    @lang('main.brilliant')</a><br class="mobile-break"/>
                    <a href="">
                    @lang('main.essential')</a><br class="mobile-break"/>
                    <a href="">
                    @lang('main.modern')</a><br class="mobile-break"/>
                    <a href="https://github.com/luksan47/mars">
                    @lang('main.open')</a><br class="mobile-break"/>
                </div>
            </div>
        </div>
    </body>
</html>