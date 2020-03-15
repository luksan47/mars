@guest
    <li><a href="{{ route('login') }}">@lang('general.login')</a></li>
    <li><a href="{{ route('register') }}">@lang('general.register')</a></li>
@else
    <ul id="dropdownUser" class="dropdown-content">
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('general.logout')</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
    </ul>
    <li><a class="dropdown-trigger" href="#!" data-target="dropdownUser"><i class="material-icons left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
@endguest