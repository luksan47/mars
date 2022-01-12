@guest
    <li><a href="{{ route('login') }}">@lang('general.login')</a></li>
    <li><a href="{{ route('register') }}"><span class="hide-on-small-only">@lang('general.register_collegist')</span></a></li>
    <li class="hide-on-small-only"><a href="{{ route('register.guest') }}">@lang('general.register_guest')</a></li>
@else
    <li><a class="waves-effect" href="{{ route('user') }}"><i class="material-icons left">account_circle</i>{{ Auth::user()->name }}</a></li>
@endguest
