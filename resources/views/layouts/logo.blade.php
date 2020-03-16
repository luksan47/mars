<a href="{{ url('/') }}">
<ul class="coli blue"style="padding:20px">
    <div class="row">
        <div class="col s12 valign-wrapper center-align">
            <img class="material-icons" style="height:80px" src="{{ env('LOGO','') }}">
            <div class="white-text noselect" style="text-indent:15px;font-size:40px;text-transform: uppercase;font-weight:300;letter-spacing:3px;" > {{ config('app.name', 'Urán') }} </div>
            <sup class="white-text noselect" style="height:15px">{{ env('APP_VERSION', '') }}</sup>
        </div>
    </div>
    <p class="center-align white-text noselect">Eötvös József Collegium</p>
</ul>
</a>