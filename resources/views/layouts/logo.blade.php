<ul class="coli blue"style="padding:20px">
    <a href="{{ url('/') }}">
    <div class="row">
        <div class="col s12 valign-wrapper center-align">
            <img class="material-icons" style="height:80px" src="{{ env('LOGO','') }}">
            <div class="white-text noselect" style="text-indent:15px;font-size:40px;text-transform: uppercase;font-weight:300;letter-spacing:3px;" > {{ config('app.name', 'Urán') }} </div>
            <sup class="white-text noselect" style="height:15px">{{ env('APP_VERSION', '') }}</sup>
        </div>
    </div>
    </a>
    <p class="center-align"><a href="https://eotvos.elte.hu/" target="_blank" class="white-text noselect">Eötvös József Collegium</a></p>
</ul>
