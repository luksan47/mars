<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ config('app.logo_with_bg_path') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tevenevelde</title>

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}" media="screen,projection" >
    <link type="text/css" rel="stylesheet" href="{{ mix('css/materialize.css') }}" media="screen,projection" />

    <!-- Scripts -->
    <script type="text/javascript" src="{{ mix('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/tabulator.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ mix('js/materialize.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/camelbreeder.js') }}" defer></script>
    <script type="text/javascript" src="{{ mix('js/moment.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
    var config = {
        routes: {
            shepherding: "{{ route('camel_breeder.shepherding') }}",
            send_shepherds: "{{route('camel_breeder.send_shepherds')}}",
            send_herds: "{{route('camel_breeder.send_herds')}}",
        },
        preloader: `@include('utils.preloader')`,
    };
    </script>
</head>

<body id="body">
    <div id="history" class="modal">
        <div class="modal-content" style="text-align: justify">
        <h4>A tevenevelde története</h4>
        <p>Egyszer volt, hol nem volt, élt egyszer a puszta közepén egy titokzatos öregember, kinek egy árva piasztere sem volt. 
        Egy nap az öregember előtt megjelent Rebeka arkangyal, s így szólott hozzája: „Kezdj el tevéket nevelni, és meglátod, ha kitartó vagy, 
        tengernyi-tengernyi pénzed lesz.”</p><p> Az öregember megfogadta a tanácsot, és 40 nap 40 éjen át keményen dolgozott, hogy felépítse tevefarmját. 
        Ahogy teltek múltak az évek, egyre több és több tevéje lett, mígnem egyszer arra járt egy nincstelen ifjú vándor. 
        A vándort az öreg tevepásztor befogadta, ő pedig fizetség gyanánt minden reggel elvitte a tevéket a közeli oázisba, 
        hogy ne haljanak szomjan. Esténként pedig az öregember elmesélte a vándornak látomásait, a farm történetét, hogy miért kezdett el tevéket nevelni.</p><p>
        Így ment ez 7 kerek éven át. A 7 év elteltével a vándor útra kelt, hogy új kalandok után nézzen, de bármerre járt,
        mindig lelkesen mesélt a titokzatos öregemberről és annak titokzatos farmjáról.</p><p>
        A farm híre szélsebesen terjedt világszerte és egyre több és több ember kereste fel a híres-neves tevefarmot. 
        Mára a titokzatos farmból egy lenyűgöző látványosság lett: a világ minden tájáról járnak oda, hogy ők is elvihessék a nevezetes tevecsordákat az oázishoz.</p><p> 
        Úgy tartják, a farmon dolgozó pásztorokra szigorú szabályok vonatkoznak: csak előre meghatározott számú tevékből álló csordát vihetnek el, 
        és azokat is csak egy bizonyos időszakban. Akik becsületesen teljesítették a próbatételt, azokat az öreg pásztor szelleme busásan megjutalmaz. 
        Arról, hogy a legbátrabb pásztoroknak mi a sorsa, nem szól a monda. A pásztorok senkinek sem beszélnek a farm történetéről és a titokzatos jutalmakról, 
        ám az a hír járja, hogy minden héten különleges szertartást tartanak, ahol különös viselkedésükkel megidézik a farm alapítóját, 
        akit csak valamilyen prófétaként emlegetnek…</p><p><i>"Sicut camelus et erit vobiscum."</i></p>
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Vissza</a>
        </div>
    </div>
    <div class="row" style="margin-top:30px;">
        <div class="container">
            @if (\Session::has('edit'))
            <a class="right btn btn-large white black-text" style="width:150px" href="{{route('camel_breeder')}}" tabindex="-1">Vissza</a>
            @else
            <ul class="right collapsible" style="width:150px">
                <li>
                    <div class="collapsible-header btn-large btn-flat white black-text" style="display: block">SZERKESZTÉS</div>
                    <div class="collapsible-body">
                        <form method="POST" id="password_form" action="{{ route('camel_breeder.password') }}">
                            @csrf
                            <input id="farmer_password" type="password" name="password" required placeholder="Titkos jelszó..." onkeydown="submitForm(event)" tabindex="-1">
                            <script>
                            function submitForm(event){
                                if(event.keyCode == 13){
                                    document.getElementById("password_form").submit();
                                }
                            }
                            </script>
                        </form>
                    </div>
                </li>
            </ul>
            @endif
            <div class="col s12">
                <a class="black-text modal-trigger" href="#history" tabindex="-1">
                    <h5 class="center-align" style="font-size:50px;font-weight:300;letter-spacing:3px;">TEVENEVELDE</h5> 
                    <img src="\img\camelbreeder.png" style="display: block;margin-left: auto;margin-right: auto;" class="center-align">
                </a>
                @if ($errors->any())
                <div class="row">
                    <blockquote class="error col offset-s1">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </blockquote>
                    <script>M.toast({html:`<i class='material-icons' style='margin-right:5px'>error</i> @foreach ($errors->all() as $error){{ $error }} @endforeach`})</script>
                </div>
                @endif
                <div class="row"> 
                    <form method="POST" id="shepherding_form" action="{{ route('camel_breeder.shepherding') }}">
                        <input type="hidden" name="herds">
                        @csrf
                        <div class="row">
                            <div class="input-field col s4 offset-s1">
                                <input type="text" id="shepherd" name="id" class="shepherd_autocomplete" 
                                    autofocus tabindex="1" required placeholder="Vendég">
                                <label for="shepherd">Pásztor</label>
                                <blockquote id="shepherd_text"><i>Válassz egy pásztort!</i></blockquote>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="herd" class="herd_autocomplete" tabindex="2"> 
                                <label for="herd">Tevecsorda</label>
                                <div id="herd_list"></div>
                                <blockquote id="herd_text"><i>Válassz egy csordát!</i></blockquote>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect" type="submit" tabindex="3" style="width:100%">Tevék nevelése</button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('camel_breeder.add_camels') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col s4 offset-s1">
                                <input type="text" id="shepherd2" name="id" class="shepherd2_autocomplete" required tabindex="4"/>
                                <label for="shepherd2">Pásztor</label>
                                <blockquote id="shepherd2_text"><i>Válassz egy pásztort!</i></blockquote>
                            </div>
                            <div class="input-field col s4">
                                <input type="number" id="camels" name="camels" required tabindex="5" min="0">
                                <label for="camels">Tevék</label>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect" type="submit" tabindex="6" style="width:100%">Tevék hozzáadása</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (\Session::has('edit'))
                @include('camel_breeder.edit')
            @endif
        </div>
    </div>
@include('utils.toast')
</body>

</html>