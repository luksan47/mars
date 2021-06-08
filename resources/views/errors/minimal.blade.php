<!-- Icons purchased via Iconfinder under Basic License -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ config('app.logo_with_bg_path') }}">

        <title>@yield('title')</title>

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <link type="text/css" rel="stylesheet" href="{{ mix('css/error_page.css') }}" media="screen,projection" >
        <script type="text/javascript" src="{{ mix('js/particles.js') }}" defer></script>
        <script type="text/javascript" src="{{ mix('js/error_page.js') }}" defer></script>
    </head>
<body class="permission_denied">
    <div id="particles-js"></div>
    <div class="denied__wrapper">
      <h1>@yield('code')</h1>
      <h3>@yield('message')</h3>

     <h3 style="margin-top: 500px">@lang('http_errors.contact') </h3>
     <a href="{{route('index_reportbug')}}"><button class="denied__link">@lang('http_errors.report')</button></a>
    </div>
</body>
</html>
