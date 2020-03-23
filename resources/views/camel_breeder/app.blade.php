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
        <p>Egyszer volt, hol nem volt, élt egyszer a puszta közepén egy titokzatos öregember, kinek egy árva piasztere sem volt. 
        Egy nap az öregember előtt megjelent Rebeka arkangyal, s így szólott hozzája: „Kezdj el tevéket nevelni, és meglátod, ha kitartó vagy, 
        tengernyi-tengernyi pénzed lesz.” Az öregember megfogadta a tanácsot, és 40 nap 40 éjen át keményen dolgozott, hogy felépítse tevefarmját. 
        Ahogy teltek múltak az évek, egyre több és több tevéje lett, mígnem egyszer arra járt egy nincstelen ifjú vándor. 
        A vándort az öreg tevepásztor befogadta, ő pedig fizetség gyanánt minden reggel elvitte a tevéket a közeli oázisba, 
        hogy ne haljanak szomjan. Esténként pedig az öregember elmesélte a vándornak látomásait, a farm történetét, hogy miért kezdett el tevéket nevelni.
        Így ment ez 7 kerek éven át. A 7 év elteltével a vándor útra kelt, hogy új kalandok után nézzen, de bármerre járt,
        mindig lelkesen mesélt a titokzatos öregemberről és annak titokzatos farmjáról.
        A farm híre szélsebesen terjedt világszerte és egyre több és több ember kereste fel a híres-neves tevefarmot. 
        Mára a titokzatos farmból egy lenyűgöző látványosság lett: a világ minden tájáról járnak oda, hogy ők is elvihessék a nevezetes tevecsordákat az oázishoz. 
        Úgy tartják, a farmon dolgozó pásztorokra szigorú szabályok vonatkoznak: csak előre meghatározott számú tevékből álló csordát vihetnek el, 
        és azokat is csak egy bizonyos időszakban. Akik becsületesen teljesítették a próbatételt, azokat az öreg pásztor szelleme busásan megjutalmaz. 
        Arról, hogy a legbátrabb pásztoroknak mi a sorsa, nem szól a monda. A pásztorok senkinek sem beszélnek a farm történetéről és a titokzatos jutalmakról, 
        ám az a hír járja, hogy minden héten különleges szertartást tartanak, ahol különös viselkedésükkel megidézik a farm alapítóját, 
        akit csak valamilyen prófétaként emlegetnek…</p>
        </div>
    </div>
    <div class="row" style="align-items: center;display: flex;">
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
                            <div class="input-field col s4 offset-s1">
                                <input type="text" id="shepherd" name="id" class="shepherd_autocomplete"
                                    onchange="showCamels(this.value, 'shepherd')" autofocus>
                                <label for="id">Pásztor</label>
                                <blockquote id="shepherd_text"><i>Válassz egy pásztort!</i></blockquote>
                                <script>
                                $(document).ready(function() {
                                    $('input.shepherd_autocomplete').autocomplete({
                                        data: {
                                            @foreach($shepherds as $shepherd)
                                            "{{$shepherd -> name}}": null,
                                            {{$shepherd -> id}}: null,
                                            @endforeach
                                        },
                                    });
                                });
                                </script>
                            </div>
                            <div class="input-field col s4">
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
                            <div class="input-field col s3">
                                <button class="btn waves-effect" type="submit">Tevék nevelése</button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="input-field col s4 offset-s1">
                                <input type="text" id="shepherd2" name="id" class="shepherd2_autocomplete"
                                    onchange="showCamels(this.value, 'shepherd2')"/>
                                <label for="id">Pásztor</label>
                                <blockquote id="shepherd2_text"><i>Válassz egy pásztort!</i></blockquote>
                                <script>
                                $(document).ready(function() {
                                    $('input.shepherd2_autocomplete').autocomplete({
                                        data: {
                                            @foreach($shepherds as $shepherd)
                                            "{{$shepherd -> name}}": null,
                                            {{$shepherd -> id}}: null,
                                            @endforeach
                                        },
                                    });
                                });
                                </script>
                            </div>
                            <div class="input-field col s4">
                                <input type="number" id="camels" name="camels">
                                <label for="herd">Tevék</label>
                            </div>
                            <div class="input-field col s3">
                                <button class="btn waves-effect" type="submit">Új tevék hozzáadása</button>
                            </div>
                        </div>
                    </form>
                    <table>
                        <tbody>
                        @foreach($shepherdings as $sh)
                        <tr>
                            <td>{{ $sh->shepherd }}</td>
                            <td>{{ $sh->herd }}</td>
                            <td>{{ $sh->created_at }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (\Session::has('success'))
    <script>M.toast({html: 'Sikeres tevézés!'})</script>
    @endif
</body>

</html>