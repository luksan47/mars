@guest
    <li><a class="waves-effect" href="{{ route('login') }}">@lang('general.login')</a></li>
    <li><a class="waves-effect" href="{{ route('register') }}">@lang('general.register')</a></li>
@else
    <li><a class="waves-effect" href="{{ route('user') }}"><i class="material-icons left">account_circle</i>{{ Auth::user()->name }}</a></li>
@endguest