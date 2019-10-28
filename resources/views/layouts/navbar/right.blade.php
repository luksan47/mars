<!-- Right Side Of Navbar -->
<ul class="navbar-nav ml-auto">
    <!-- Authentication Links -->
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">@lang('general.login')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">@lang('general.register')</a>
        </li>
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->name }} <span class="caret"></span></a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    @lang('general.logout')
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
    
    <!-- language selector -->
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ config('app.locales')[App::getLocale()] }} <span class="caret"></span></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            @foreach (config('app.locales') as $code => $name) 
                @if ($code != App::getLocale())
                    <a class="dropdown-item" href="{{ route('setlocale', $code) }}">{{ $name }}</a>
                @endif
            @endforeach
        </div>
    </li>                
</ul>
