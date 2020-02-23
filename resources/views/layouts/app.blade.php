<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/uran.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Urán') }}</title>

    <!-- Styles -->
    <!--
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-formhelpers.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tabulator_materialize.min.css') }}">
    
    <!--<link rel="stylesheet" href="{{ asset('css/site.css') }}">-->
    <link rel="stylesheet" href="{{ asset('css/cookieconsent.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.css') }}"  media="screen,projection"/>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-formhelpers.min.js') }}"></script>
    <script src="{{ asset('js/tabulator.min.js') }}" defer></script>
    <script src="{{ asset('js/site.js') }}" defer></script>
    <script src="{{ asset('js/cookieconsent.min.js') }}" defer></script>
    <script src="{{ asset('js/cookieconsent-initialize.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/materialize.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(
            function() {
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }});
                $('.sidenav').sidenav();
                $(".dropdown-trigger-navbar").dropdown({hover: false});
                $(".dropdown-trigger-sidebar").dropdown();
                $(".dropdown-trigger-settings").dropdown(); //TODO
            }
        );
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
    <header>
        @include('layouts.navbar')
    </header>
    <div class="row">
        @include('layouts.sidebar')
        <div class="container">
            <div class="col s12 m12 l3"><!--space sidenav--></div>
            <div class="col s12 m12 l9">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        var cookieMessages = {
            'dismiss' : "@lang('cookie.dismiss')",
            'allow' : "@lang('cookie.allow')",
            'deny' : "@lang('cookie.deny')",
            'link' : "@lang('cookie.link')",
            'cookie' : "@lang('cookie.message')",
            'header' : "@lang('cookie.header')",
        };
    </script>
</body>

</html>
