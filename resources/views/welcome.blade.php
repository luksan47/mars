<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
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
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Urán 2.0
                </div>

                <div class="links">
                    <a href="https://scontent-vie1-1.xx.fbcdn.net/v/t1.0-9/70482435_2434340146842681_7236757595812265984_n.jpg?_nc_cat=109&_nc_oc=AQmvj-nFmQMq86yWMS8G6E4_WMcPCEfXaq94cMse0xiw2-nFMLZ3RlDPGbeYrNUv4z8&_nc_ht=scontent-vie1-1.xx&oh=d11bcdf683830b4305af9c00ec50ca17&oe=5E3D6A4D">
                    Eötvös</a>
                    <a href="https://www.elte.hu/media/93/3a/2bf999767a05043e13a387d2a89d0b25e039aed6db2c47f35144dfb9e27e/stock-computer2.jpg">
                    ELTE</a>
                    <a href="data:image/jpeg;base64,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">
                    Urán 1.1</a>
                    <a href="https://media.makeameme.org/created/kibaszott-kurva-neptun.jpg">
                    Neptun</a>
                    <a href="https://www.arcanum.hu/hu/online-kiadvanyok/Lexikonok-a-magyar-nyelv-ertelmezo-szotara-1BE8B/f-28F2F/fantasztikus-293A1/">
                    Mars (Urán 2.0)</a>
                    <a href="https://bullshitnews.org/">
                    Hírek</a>
                    <a href="https://propakistani.pk/2019/07/31/pia-is-offering-up-to-20-discounts-for-a-limited-time/">
                    Estike</a>
                </div>
            </div>
        </div>
    </body>
</html>
