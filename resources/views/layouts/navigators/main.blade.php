@auth
    @if (Auth::user()->verified)
        <li><a href="{{ route('print') }}"><i class="material-icons left">local_printshop</i>@lang('print.print')</a></li>
        <li><a href="{{ route('internet') }}"><i class="material-icons left">wifi</i>@lang('internet.internet')</a></li>
        <li><a href="{{ route('faults') }}"><i class="material-icons left">build</i>@lang('faults.faults')</a></li>
        @if (Auth::user()->hasRole(\App\Role::INTERNET_ADMIN))
            <li><div class="divider"></div></li>
            <li><a class="subheader">@lang('admin.admin')</a></li>
            <li><a href="{{ route('admin.registrations') }}"> @lang('admin.handle_registrations')</a></li>
            <li><a href="{{ route('print.admin') }}">@lang('print.print')</a></li>
            <li><a href="{{ route('internet.admin') }}">@lang('internet.internet')</a></li>
        @endif
    @endif
@endauth