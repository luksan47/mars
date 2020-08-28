<!--navbar-->
<div class="navbar-fixed">
    <nav class="top-nav">
        <div class="nav-wrapper">
            <div class="row">
                <!--sidenav trigger for mobile-->
                <a href="#" data-target="sidenav" class="sidenav-trigger hide-on-large-only"><i
                        class="material-icons">menu</i></a>
                <!--logo for mobile-->
                <a class="brand-logo center hide-on-large-only"
                    style="text-transform: uppercase;font-weight:300;letter-spacing:3px;" href="{{ url('/') }}">
                    {{ config('app.name', 'Urán') }} </a>
                <!--title-->

                <div class="col hide-on-med-and-down noselect" style="margin-left:310px">
                    @yield('title')
                </div>

                <!-- Right Side Of Navbar -->
                <ul class="right hide-on-med-and-down">
                    @include('layouts.navigators.user')
                </ul>
            </div>
        </div>
    </nav>
</div>

<!--sidebar-->
<ul class="sidenav sidenav-fixed" id="sidenav">
    <!-- logo -->
    @include('layouts.logo')

    <!-- main options -->
    @if(Auth::user() && Auth::user()->verified)
        <!-- print page -->
        @can('print.print')
        <li><a class="waves-effect" href="{{ route('print') }}"><i class="material-icons left">local_printshop</i>@lang('print.print')</a></li>
        @endif
        <!-- internet page -->
        @can('internet.internet')
        <li><a class="waves-effect" href="{{ route('internet') }}"><i class="material-icons left">wifi</i>@lang('internet.internet')</a></li>
        @endif
        <!-- faults page -->
        <li><a class="waves-effect" href="{{ route('faults') }}"><i class="material-icons left">build</i>@lang('faults.faults')</a></li>
        
        <li><div class="divider"></div></li>
        
        <!-- collapsible modules -->
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <!-- admin module -->
                @can('print.modify') {{-- TODO: make a general admin policy --}}
                <li>
                    <a class="collapsible-header waves-effect" style="padding-left:32px">
                        <i class="material-icons left">edit</i>
                        @lang('admin.admin')
                        <i class="material-icons right">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <!-- registrations -->
                            <li><a class="waves-effect" href="{{ route('admin.registrations') }}"> @lang('admin.handle_registrations')</a></li>
                            <!-- print admin -->
                            <li><a class="waves-effect" href="{{ route('print.admin') }}">@lang('print.print')</a></li>
                            <!-- internet admin -->
                            <li><a class="waves-effect" href="{{ route('internet.admin') }}">@lang('internet.internet')</a></li>
                            <!-- permission admin -->
                            @if(Auth::user()->hasRole(\App\Role::PERMISSION_HANDLER))
                            <li>
                                <a class="waves-effect" href="{{ route('admin.permissions.list') }}">
                                <i class="material-icons left">lock</i>@lang('admin.permissions')
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                {{-- Paste other collapsible option groups here eg. secretariat module, commitee modules --}}
            </ul>
        </li>         
    @endif

    <li><div class="divider"></div></li>
    
    <!-- User page or register/login -->
    <div class="hide-on-large-only">
        @include('layouts.navigators.user')
    </div>

    <li>
        <ul class="collapsible collapsible-accordion">
            <!-- language select -->
            <li>
                <a class="collapsible-header waves-effect" style="padding-left:32px">
                    <i class="material-icons left">language</i>Language
                    <i class="material-icons right">arrow_drop_down</i></a>
                <div class="collapsible-body">
                    <ul>
                        @foreach (config('app.locales') as $code => $name)
                        <li><a class="waves-effect" href="{{ route('setlocale', $code) }}">{{ $name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <!-- other -->
            @if(Auth::user() && Auth::user()->verified)
            <li>
                <a class="collapsible-header waves-effect" style="padding-left:32px">
                    <i class="material-icons left">more_horiz</i>@lang('general.other')
                    <i class="material-icons right">arrow_drop_down</i></a>
                <div class="collapsible-body">
                    <ul>
                        <!-- language contributions -->
                        <li><a href="{{ route('localizations') }}">
                            <i class="material-icons left">sentiment_satisfied_alt</i>@lang('localizations.help_translate')</a></li>

                        <!-- report a bug --> 
                        <script>
                            //The href: mailto may not work on every device. In this case, show a notification.
                            var myHTML = "<span>@lang('general.if_mail_not_working')</span><button class='btn-flat toast-action' onclick='dismiss()'>OK</button>";
                            function dismiss() {
                                M.Toast.dismissAll();
                            };
                        </script>
                        <li><a href="mailto:root@eotvos.elte.hu?Subject=[urán%20bug]" onclick="M.toast({html: myHTML, displayLength: 10000})">
                            <i class="material-icons left">sentiment_very_dissatisfied</i>@lang('general.report_bug')</a></li>
                    </ul>
                </div>
            </li>
            @endif  
        </ul>
    </li>

    <!-- logout -->
    @if(Auth::user())
    <li>
        <a class="waves-effect" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="material-icons left">login</i>@lang('general.logout')
        </a>
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endif
        
</ul>