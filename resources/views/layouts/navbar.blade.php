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
        @can('use', \App\Models\PrintAccount::class)
        <li><a class="waves-effect" href="{{ route('print') }}"><i class="material-icons left">local_printshop</i>@lang('print.print')</a></li>
        @endif
        <!-- internet page -->
        @can('possess', \App\Models\InternetAccess::class)
        <li><a class="waves-effect" href="{{ route('internet') }}"><i class="material-icons left">wifi</i>@lang('internet.internet')</a></li>
        @endif
        <!-- faults page -->
        <li><a class="waves-effect" href="{{ route('faults') }}"><i class="material-icons left">build</i>@lang('faults.faults')
                @if (Auth::user()->hasRole(\App\Models\Role::STAFF))
                    @notification(\App\Models\Fault::class)
                @endif
            </a>
        </li>
        <!-- documents page -->
        @can('document.any')
        <li><a class="waves-effect" href="{{ route('documents') }}"><i class="material-icons left">assignment</i>@lang('document.documents')</a></li>
        @endcan

        <!-- collapsible modules -->
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <!-- students' council module -->
                @can('viewAny', \App\Models\Checkout::class)
                <li><div class="divider"></div></li>
                <li class="@yield('student_council_module')">
                    <a class="collapsible-header waves-effect" style="padding-left:32px">
                        <i class="material-icons left">groups</i> <!-- star icon? -->
                        @lang('role.student-council')
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <!-- economic committee -->
                            <li>
                                <a class="waves-effect" href="{{ route('economic_committee') }}">
                                    <i class="material-icons left">attach_money</i> @lang('role.economic-committee')
                                </a>
                            </li>
                            <!-- communication committee -->
                            <li>
                                <a class="waves-effect" href="{{ route('epistola') }}">
                                    <i class="material-icons left">rss_feed</i> @lang('role.communication-committee')
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                <!-- secretariat module -->
                @if(Auth::user()->hasElevatedPermissions())

                <li><div class="divider"></div></li>
                <li class="@yield('secretariat_module')">
                    <a class="collapsible-header waves-effect" style="padding-left:32px">
                        <i class="material-icons left">business_center</i>
                        @lang('general.secretariat')
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <!-- registrations -->
                            @can('registration.handle')
                            <li>
                                <a class="waves-effect" href="{{ route('secretariat.registrations') }}">
                                    <i class="material-icons left">how_to_reg</i> @lang('admin.handle_registrations')
                                    @notification(\App\Models\User::class)
                                </a>
                            </li>
                            @endcan

                            <!-- user management -->
                            @can('viewAny', \App\Models\User::class)
                            <li>
                                <a class="waves-effect" href="{{ route('secretariat.user.list') }}">
                                    <i class="material-icons left">supervisor_account</i> @lang('admin.user_management')
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                {{-- Sysadmin module --}}
                <li><div class="divider"></div></li>
                <li class="@yield('admin_module')">
                    <a class="collapsible-header waves-effect" style="padding-left:32px">
                        <i class="material-icons left">edit</i>
                        @lang('admin.admin')
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <!-- print admin -->
                            @can('handleAny', \App\Models\PrintAccount::class)
                            <li>
                                <a class="waves-effect" href="{{ route('print.manage') }}">
                                    <i class="material-icons left">local_printshop</i>@lang('print.print')
                                </a>
                            </li>
                            @endcan

                            <!-- internet admin -->
                            @can('handleAny', \App\Models\InternetAccess::class)
                            <li>
                                <a class="waves-effect" href="{{ route('internet.admin') }}">
                                    <i class="material-icons left">wifi</i>@lang('internet.internet')
                                </a>
                            </li>
                            <li>
                                <a class="waves-effect" href="{{ route('routers') }}">
                                    <i class="material-icons left">router</i>@lang('router.router_monitor')
                                    @notification(\App\Models\Router::class)
                                </a>
                            </li>
                            @endcan

                            <li>
                            <a class="waves-effect" href="{{ route('admin.checkout') }}">
                                <i class="material-icons left">credit_card</i> @lang('admin.checkout')
                            </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
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
                        <li><a href="{{ route('index_reportbug') }}">
                            <i class="material-icons left">sentiment_very_dissatisfied</i>@lang('general.report_bug')</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a class="dark-toggle" href="#" onclick="toggleColorMode()" title="Dark/light"><i class="material-icons left">brightness_4</i>@lang('general.toggle-dark-mode')</a>
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

@push('scripts')
    <script>
        //The href: mailto may not work on every device. In this case, show a notification.
        var myHTML = "<span>@lang('general.if_mail_not_working')</span><button class='btn-flat toast-action' onclick='dismiss()'>OK</button>";
        function dismiss() {
            M.Toast.dismissAll();
        };
    </script>
@endpush
