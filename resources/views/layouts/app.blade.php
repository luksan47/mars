<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Urán') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })});
    </script>
    <script src="{{ asset('js/tabulator.min.js') }}" defer></script>
    <script src="{{ asset('js/site.js') }}" defer></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tabulator_bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        var cookieMessages = {
            'dismiss' : "{{ __('cookie.dismiss') }}",
            'allow' : "{{ __('cookie.allow') }}",
            'deny' : "{{ __('cookie.deny') }}",
            'link' : "{{ __('cookie.link') }}",
            'cookie' : "{{ __('cookie.message') }}",
            'header' : "{{ __('cookie.header') }}",
        };
    </script>
    <script src="{{ asset('js/cookieconsent.min.js') }}"></script>
    <script src="{{ asset('js/cookieconsent-initialize.js') }}"></script>
</body>
</html>
