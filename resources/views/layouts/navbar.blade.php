<div class="navbar-fixed">
    <nav class="top-nav primary-color">
        <div class="nav-wrapper">
            <div class="row">
                <a href="#" data-target="mobile-sidenav" class="sidenav-trigger hide-on-large-only"><i class="material-icons">menu</i></a>
                <a class="brand-logo center hide-on-large-only" style="text-transform: uppercase;font-weight:300;letter-spacing:3px;" href="{{ url('/') }}"> {{ config('app.name', 'Urán') }} </a>
                <!-- Right Side Of Navbar -->
                <ul class="right hide-on-med-and-down">
                    @include('layouts.navbar.right')
                </ul>
            </div>
        </div>
    </nav>
</div>
<!--Mobile-->
<ul class="sidenav" id="mobile-sidenav">
    @include('layouts.navbar.left')
    @include('layouts.navbar.right')
</ul>

