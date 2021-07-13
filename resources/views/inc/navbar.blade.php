
<nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top">
    <a class="navbar-brand" href=" @guest {{ url('/') }} @else {{ route('home') }} @endguest ">
        <img src="{{ asset('img/ec_logo.png') }}" style="height: 3em" alt="" srcset="">
        Eötvös Collegium Felvételi {{ date("Y") }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">

            @can('isAdmin')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle btn btn-secondary border-primary" id="navbarDropdown_workshops" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown_workshops">
                    <a href="{{ route('admin.users.list') }}" class="dropdown-item">Felhasználók</a>
                    <a href="{{ route('admin.applications.show_all') }}" class="dropdown-item">Jelentkezések</a>
                    <a href="{{ route('admin.register') }}" class="dropdown-item">Regisztrálás</a>
                </div>
            </li>
            @endcan


            @can('isUserOrAdmin')
            @if ( count( auth()->user()->list_permissions ?? []) > 0 )
                <li class="nav-item  dropdown">
                    <a href="#" class="nav-link dropdown-toggle btn btn-secondary border-primary" id="navbarDropdown_workshops" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Jelentkezések
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown_workshops">
                        @foreach ( auth()->user()->list_permissions ?? [] as $list_permission )
                            <a class="dropdown-item" href="{{ route( \App\Permissions::LISTS[$list_permission['permission']]['route_name'] ) }}">
                                {{ \App\Permissions::LISTS[$list_permission['permission']]['name'] }}
                            </a>
                        @endforeach
                    </div>
                </li>
                @endif
            @endcan

            @can('isUserOrAdmin')
            <li class="nav-item  dropdown">
                <a href="#" class="nav-link dropdown-toggle btn btn-secondary border-primary" id="navbarDropdown_workshops" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Műhelyek
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown_workshops">
                    @if ( count( auth()->user()->workshop_permissions ?? []) > 0 )
                        @foreach ( auth()->user()->workshop_permissions ?? [] as $workshop_permission )
                            <a class="dropdown-item" href="{{ route('user.applications.list.workshop',['workshop_url' => \App\Permissions::cast_workshop_code_to_url($workshop_permission['permission'])]) }}">
                                {{ \App\Permissions::WORKSHOPS[$workshop_permission['permission']]['name'] }}
                            </a>
                        @endforeach
                    @else
                        <div class="px-2"><small>Nincs hozzáférésed egy műhely listájához sem.</small></div>
                    @endif
                </div>
            </li>
            @endcan



            @can('isApplicant')

                @can('hasApplicationAndUnFinalised')
                    <li class="nav-item">
                        <a href="{{ route('applicant.profile.edit') }}" class="nav-link btn btn-secondary border-primary">Jelentkezés</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('applicant.uploads') }}" class="nav-link btn btn-secondary border-primary">Feltöltések</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('applicant.final') }}" class="nav-link btn btn-secondary border-primary">Véglegesítés</a>
                    </li>

                @elsecan('hasApplicationAndFinalised')
                    <li class="nav-item">
                        <a href="{{ route('applicant.profile') }}" class="nav-link btn btn-secondary border-primary">Jelentkezés megtekintése</a>
                    </li>

                @endcan
            @endcan

            @guest
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link btn btn-secondary border-primary">
                        Jelentkezés
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link btn btn-secondary border-primary">
                        Belépés
                    </a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link navbar-brand dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}<span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        @can('isApplicant')
                            <a href="{{ route('applicant.profile') }}" class="dropdown-item">Profil</a>
                        @endcan

                        @can('isUserOrAdmin')
                            <a href="{{ route('user.profile') }}" class="dropdown-item">Profil</a>
                        @endcan

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            Kilépés
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
