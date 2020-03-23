<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ env('LOGO','') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tevenevelde</title>

    <!-- Styles -->
    <!-- materialize css generated from resources/sass/materialize.scss-->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.css') }}" media="screen,projection" />

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <!-- modified materialize js for searchable select: https://codepen.io/yassinevic/pen/eXjqjb?editors=1111 -->
    <script type="text/javascript" src="{{ asset('js/materialize.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
    $(document).ready(function(){
        $('.modal').modal();
    });
    const shepherds = {
        @foreach($shepherds as $shepherd) 
        "{{ $shepherd -> name }}": {{ $shepherd -> id}},
        @endforeach
    };
    const camels = {
        @foreach($shepherds as $shepherd) 
        {{ $shepherd -> id }}: {name: '{{ $shepherd -> name }}', camels: {{ $shepherd -> camels ?? 0 }} },
        @endforeach
    };
    const herds = {
        @foreach($herds as $herd) 
        "{{ $herd -> name }}": {{ $herd -> camel_count }},
        @endforeach
    };

    function showCamels(val, elementId) {
        input = document.getElementById(elementId);
        info = document.getElementById(elementId+'_text'); 
        input.classList.remove("invalid");
        if(!isNaN(val)){
            id=val;
        }
        else {
            id=shepherds[val];
            input.value=id;
        }
        if (!(id in camels)){
            input.classList.add("invalid");
            info.innerHTML = "Nincs ilyen pásztor!";
        }
        else{
            if (id == 0) {
                text = "<i>Válassz egy pásztort!</i>"
            } else {
                text = "<i>" + camels[id].name + "</i> tevéinek száma: " + camels[id].camels;
            }
            info.innerHTML = text;
        }
    }

    function showHerds(name) {
        info = document.getElementById('herd_text');
        input = document.getElementById('herd');
        input.classList.remove("invalid");
        if (!(name in herds)){
            input.classList.add("invalid");
            info.innerHTML = "Nincs ilyen csorda!";
        }else{
            text = "Ez a csorda " + herds[name] + " tevéből áll.";
            info.innerHTML = text;
        }
    }
    function toggleHistory() {
        var x = document.getElementById("history");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    </script>
</head>

<body>
    <div id="history" class="modal">
        <div class="modal-content">
        <h4>A tevenevelde története</h4>
        <p>Egyszer volt hol nem volt, volt egyszer egy titokzatos öregember, aki a sivatag közepén élt, ahol a madár se járt. 
            Egy nap volt egy látomása, aminek hatására tevéket kezdett el nevelni. Fel is építette hát a kis farmját, és ahogy teltek múltak az idők, egyre több tevéje lett, mígnem egyszer arra járt egy fiatal kalandozó.
            A kalandort az öreg pásztor befogadta, majd munkát is ajánlott neki. 
            A következő három hónapban a kalandor a pásztornak dolgozott, a tevéit minden reggel elvitte sétálni.
            Az öregember elmesélte neki a történeteit, látomásait, hogy miért kezdett el tevéket nevelni, és hogy miért jött el Mekkából a sivatag közepébe.
            A három hónap letelte után a kalandor visszatért hazájába, és hírül vitte, hogy milyen jól érezte magát azon a titokzatos farmon.
            Ezek után öreg pásztor arra lett figyelmes, hogy egyre több kalandor keresi fel farmját.
            Az idők teltek, múltak, a titokzatos farmból egy hatalmas látványosság lett mára.
            A világ minden tájáról járnak oda, csak hogy ők is elvihessék a híres-neves tevecsordákat sétálni.
            A monda szerint a farmon dolgozó pásztorokra szigorú szabályok vonatkoznak:
            A pásztorok jelezhetik, hogy mennyi tevét vinnének el sétálni, majd ezután tevecsordákban, meghatározott időszakban vihetik el a tevéket. 
            Ha teljesítették a próbatételeket, az öregember szelleme bőséges jutalmakkal látja el a bátor pásztorokat.
            Azt, hogy mi történik a legbátrabb pásztorokkal, arról még a monda sem szól.
            A pásztorok nem beszélnek a tevenevelés hátteréről, se a titokzatos jutalmakról, ám egyes látogatók szerint a pásztorok szertartásokat szerveznek minden héten, ahol különösen viselkednek, és megidézik a farm alapítóját, akit csak valamilyen prófétaként emlegetnek.
        </p>
        </div>
    </div>
    <div class="row" style="height: 90vh; align-items: center;display: flex;">
        <div class="container">
        <a class="left waves-effect btn-flat modal-trigger" href="#history">Történet</a>
        <a class="right waves-effect btn-flat" href="/camelbreeder/edit">Szerkesztés</a>
            <div class="col s12">
                <h5 class="center-align" style="font-size:50px;font-weight:300;letter-spacing:3px;">TEVENEVELDE</h5> 
                <img src="\img\camelbreeder.png" style="display: block;margin-left: auto;margin-right: auto;" class="center-align">
                <div class="row">             
                    @if ($errors->any())
                        <blockquote class="error">
                            @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </blockquote>
                    @endif
                    <form method="POST" action="{{ route('shepherding') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col s5">
                                <input type="text" id="shepherd" name="id" class="shepherd_autocomplete"
                                    onchange="showCamels(this.value, 'shepherd')" autofocus>
                                <label for="id">Pásztor</label>
                                <blockquote id="shepherd_text"><i>Válassz egy pásztort!</i></blockquote>
                                <script>
                                $(document).ready(function() {
                                    $('input.shepherd_autocomplete').autocomplete({
                                        data: {
                                            @foreach($herds as $herd)
                                            "{{$shepherd -> name}}": null,
                                            {{$shepherd -> id}}: null,
                                            @endforeach
                                        },
                                    });
                                });
                                </script>
                            </div>
                            <div class="input-field col s5">
                                <input type="text" id="herd" name="name" class="herd_autocomplete"
                                    onchange="showHerds(this.value)">
                                <label for="herd">Tevecsorda</label>
                                <blockquote id="herd_text"><i>Válassz egy csordát!</i></blockquote>
                                <script>
                                $(document).ready(function() {
                                    $('input.herd_autocomplete').autocomplete({
                                        data: {
                                            @foreach($herds as $herd)
                                            "{{$herd -> name}}": null,
                                            @endforeach
                                        },
                                    });
                                });
                                </script>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect right" type="submit">Tevék nevelése</button>
                            </div>
                            @if (\Session::has('success'))
                                <script>M.toast({html: 'Sikeres tevenevelés!})</script>
                            @endif
                        </div>
                    </form>
                    <form method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="input-field col s5">
                                <input type="text" id="shepherd2" name="id" class="shepherd2_autocomplete"
                                    onchange="showCamels(this.value, 'shepherd2')" autofocus>
                                <label for="id">Pásztor</label>
                                <blockquote id="shepherd2_text"><i>Válassz egy pásztort!</i></blockquote>
                                <script>
                                $(document).ready(function() {
                                    $('input.shepherd2_autocomplete').autocomplete({
                                        data: {
                                            @foreach($herds as $herd)
                                            "{{$shepherd -> name}}": null,
                                            {{$shepherd -> id}}: null,
                                            @endforeach
                                        },
                                    });
                                });
                                </script>
                            </div>
                            <div class="input-field col s5">
                                <input type="number" id="camels" name="camels">
                                <label for="herd">Tevék</label>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect right" type="submit">Új tevék hozzáadása</button>
                            </div>
                            @if (\Session::has('success'))
                                <script>M.toast({html: 'Sikeres hozzáadás'})</script>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>