@auth
    @if (Auth::user()->verified)
        @can('print.print')
        <li><a href="{{ route('print') }}"><i class="material-icons left">local_printshop</i>@lang('print.print')</a></li>
        @endif
        @can('internet.internet')
        <li><a href="{{ route('internet') }}"><i class="material-icons left">wifi</i>@lang('internet.internet')</a></li>
        @endif
        <li><a href="{{ route('faults') }}"><i class="material-icons left">build</i>@lang('faults.faults')</a></li>
        @can('print.modify') <!-- TODO: make a general admin policy-->
            <li><div class="divider"></div></li>
            <li><a class="subheader">@lang('admin.admin')</a></li>
            <li><a href="{{ route('admin.registrations') }}"> @lang('admin.handle_registrations')</a></li>
            <li><a href="{{ route('print.admin') }}">@lang('print.print')</a></li>
            <li><a href="{{ route('internet.admin') }}">@lang('internet.internet')</a></li>
        @endif
        @if(Auth::user()->hasRole(\App\Role::CAMEL_BREEDER))
            <li><div class="divider"></div></li>
            <li><a href="{{ route('camel_breeder') }}">Tevenevelde</a></li>
        @endif
    @endif
@endauth 