<ul class="sidenav sidenav-fixed">
    <ul class="primary-color" style="padding:20px">
        <div class="row">
            <div class="col s12 valign-wrapper center-align">
                <!--<img class="responsive-img " style="height:100px" src="img/eotvos_logo.png">-->
                <!--<i class="material-icons" style="color:white;height:40px">public</i>-->
                <img class="material-icons" style="height:80px" src="img/uran.png">
                <a class=" white-text" style="text-indent:15px;font-size:40px;text-transform: uppercase;font-weight:300;letter-spacing:3px;"; href="{{ url('/') }}"> {{ config('app.name', 'Urán') }} </a>
            </div>
        </div>
        <p class="white-text center-align">Eötvös József Collegium</p>
    </ul>
    <li><a class="subheader">Urán</a></li>
    @include('layouts.navbar.left')
    <li><div class="divider"></div></li>
    <li><a class="subheader">News</a></li>
    <li><a href="#">Hamarosan...</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Választmány</a></li>
    <li><a href="#">Hamarosan...</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#" class="secondary-text-color">Report a bug</a></li>

</ul>