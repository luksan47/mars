@guest
    <li><a href="{{ route('login') }}">@lang('general.login')</a></li>
    <li><a href="{{ route('register') }}">@lang('general.register')</a></li>
@else
    <li><a href="{{ route('user') }}"><i class="material-icons left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
@endguest