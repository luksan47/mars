@auth
    @if (Auth::user()->verified)
        <li><a href="{{ route('print') }}"><i class="material-icons left">local_printshop</i>@lang('print.print')</a></li>
        <li><a href="{{ route('internet') }}"><i class="material-icons left">wifi</i>@lang('internet.internet')</a></li>
        <li><a href="#">Szobabeosztás (hamarosan...)</a></li>
        <li><a href="#">Terembeosztás (hamarosan...)</a></li>
        <li><a href="#">Mosófüzet (hamarosan...)</a></li>
        
        @if (Auth::user()->hasRole(\App\Role::INTERNET_ADMIN))
        <ul id="dropdownAdmin" class="dropdown-content">
            <li><a href="{{ route('admin.registrations') }}"> @lang('admin.handle_registrations')</a></li>
            <li><a href="{{ route('internet.admin') }}">@lang('internet.internet')</a></li>
        </ul>
        <li><a class="dropdown-trigger" href="#!" data-target="dropdownAdmin"><i class="material-icons left">language</i>@lang('admin.admin')<i class="material-icons right">arrow_drop_down</i></a></li>
        @endif
    @endif
@endauth