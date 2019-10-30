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
            
            @if (Auth::user()->hasRole(\App\Role::INTERNET_ADMIN))
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('admin.admin') }} <span class="caret"></span></a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.registrations') }}"> {{ __('admin.handle_registrations') }}</a>
                        <a class="dropdown-item" href="{{ route('internet.admin') }}">{{ __('internet.internet') }}</a>
                    </div>
                </li>
            @endif
        @endif
    @endauth
</ul>
