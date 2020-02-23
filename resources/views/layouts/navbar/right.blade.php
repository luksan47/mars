@guest
    <li><a href="{{ route('login') }}">@lang('general.login')</a></li>
    <li><a href="{{ route('register') }}">@lang('general.register')</a></li>
@else
    <ul id="dropdownUser" class="dropdown-content">
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('general.logout')</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
    </ul>
    <li><a class="dropdown-trigger-settings" href="#!" data-target="dropdownUser"><i class="material-icons left">account_circle</i>{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
@endguest
<ul id="dropdownLang" class="dropdown-content">
    @foreach (config('app.locales') as $code => $name) 
        @if ($code != App::getLocale())
            <li><a href="{{ route('setlocale', $code) }}">{{ $name }}</a></li>
        @endif
    @endforeach
</ul>
<li><a class="dropdown-trigger-settings" href="#!" data-target="dropdownLang"><i class="material-icons left">language</i>Language<i class="material-icons right">arrow_drop_down</i></a></li> 
