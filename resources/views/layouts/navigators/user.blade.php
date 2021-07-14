@guest
    <li><a class="waves-effect" href="{{ route('login') }}">@lang('general.login')</a></li>
    <li><a class="waves-effect" href="{{ route('register') }}">@lang('general.admission')</a></li>
    <li><a class="waves-effect" href="{{ route('register') }}">@lang('general.register') @lang('general.register_guest')</a></li>
@else
    <li><a class="waves-effect" href="{{ route('user') }}"><i class="material-icons left">account_circle</i>{{ Auth::user()->name }}</a></li>
@endguest