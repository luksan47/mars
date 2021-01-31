<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <!-- indicate mobile friendly page-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- change status bar color on supported mobile browsers -->
    <meta name="theme-color" content="#252A51">
    <!-- change the page's icon in the browser's tab -->
    <link rel="icon" href="{{ config('app.logo_with_bg_path') }}">
    <!-- CSRF Token for Laravel's forms -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Urán') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;1,300;1,400;1,600&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/materialize.css') }}" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}" media="screen,projection" >

    <!-- Scripts -->
    <script type="text/javascript" src="{{ mix('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/tabulator.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ mix('js/cookieconsent.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ mix('js/cookieconsent-initialize.js') }}" defer></script>
    <script type="text/javascript" src="{{ mix('js/materialize.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/site.js') }}"></script>
    <script>
        $(document).ready(
            function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                $('.sidenav').sidenav();
                $('.collapsible').collapsible();
            }
        );
    </script>

</head>

<body class="{{ Cookie::get('theme') }}">
    <header>
        @include('layouts.navbar')
    </header>
    <div class="row">
        <div class="container">
            <div class="col s12 m12 l11 offset-xl2 offset-l3">
                @yield('content')
            </div>
        </div>
    </div>
    @include('utils.toast')
    @push('scripts')
        <script>
        var cookieMessages = {
            'dismiss': "@lang('cookie.dismiss')",
            'allow': "@lang('cookie.allow')",
            'deny': "@lang('cookie.deny')",
            'link': "@lang('cookie.link')",
            'cookie': "@lang('cookie.message')",
            'header': "@lang('cookie.header')",
        };
        </script>
        @if (config('app.debug'))
            <script>
                $(document).ready(function(){
                    $('.tooltipped').tooltip();
                });
            </script>
        @endif
        <script>
            function toggleColorMode() {
                var mode = (localStorage.getItem('mode') || 'dark') === 'dark' ? 'light' : 'dark';
                localStorage.setItem('mode', mode);
                if(localStorage.getItem('mode') === 'dark') {
                    document.querySelector('body').classList.add('dark');
                } else {
                    document.querySelector('body').classList.remove('dark');
                }

                // Save as cookie
                $.ajax({
                    type: "POST",
                    url: "{{ route('set-color-mode', [':mode']) }}".replace(':mode', mode),
                });
            }
        </script>
    @endpush

    @stack('scripts')
</body>

</html>
