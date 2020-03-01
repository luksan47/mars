<!-- Left Side Of Navbar -->
<ul class="navbar-nav mr-auto">
    @auth
        @if (Auth::user()->verified)
        
            <li class="nav-item">
                <a class="nav-link" href="{{ route('print') }}">@lang('print.print')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('internet') }}">@lang('internet.internet')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('faults') }}">@lang('faults.faults')</a>
            </li>
            
            @if (Auth::user()->hasRole(\App\Role::INTERNET_ADMIN))
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @lang('admin.admin')
                        <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.registrations') }}"> @lang('admin.handle_registrations')</a>
                        <a class="dropdown-item" href="{{ route('internet.admin') }}">@lang('internet.internet')</a>
                    </div>
                </li>
            @endif
        @endif
    @endauth
</ul>
