<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Urán') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    @if (Auth::user()->verified)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('print') }}">{{ __('print.print') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('internet') }}">{{ __('internet.internet') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('faults') }}">{{ __('faults.faults') }}</a>
                        </li>
                        @if (Auth::user()->hasRole(\App\Role::INTERNET_ADMIN))
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('admin.admin') }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.registrations') }}"> {{ __('admin.handle_registrations') }} </a>
                                <a class="dropdown-item" href="{{ route('internet.admin') }}">{{ __('internet.internet') }} </a>
                            </div>
                        </li>
                        @endif
                    @endif
                @endauth
            </ul>

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
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

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
                <li>
                @if (App::isLocale('en'))
                    <a class="nav-link" href="{{ route('setlocale', 'hu') }}">{{ __('HU') }}</a>
                @else
                    <a class="nav-link" href="{{ route('setlocale', 'en') }}">{{ __('EN') }}</a>
                @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
