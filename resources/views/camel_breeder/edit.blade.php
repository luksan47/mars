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
    const shepherd_names = [
        @foreach($shepherds as $shepherd) 
        "{{ $shepherd -> name }}",
        @endforeach
    ];
    const shepherd_ids = [
        @foreach($shepherds as $shepherd) 
        "{{ $shepherd -> id }}",
        @endforeach
    ];
    function validName(name) {
        info = document.getElementById('name_text');
        input = document.getElementById('shepherd_name');
        input.classList.remove("invalid");
        info.innerHTML = "";
        if (shepherd_names.indexOf(name) >= 0){
            input.classList.add("invalid");
            info.innerHTML = "Ez a név már foglalt!";
        }
    }

    function validId(id) {
        info = document.getElementById('id_text');
        input = document.getElementById('shepherd_id');
        input.classList.remove("invalid");
        info.innerHTML = "";
        if (shepherd_ids.indexOf(id) >= 0){
            input.classList.add("invalid");
            info.innerHTML = "Ez a szám már foglalt!";
        }
    }
    </script>
</head>

<body>
    <div class="row" style="height: 90vh; align-items: center;display: flex;">
        <div class="container">
            <a class="right waves-effect btn-flat" href="/camelbreeder">Vissza</a>
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
                </div>
                <div class="row">
                    <h5>Új pásztor hozzáadása</h5>
                    <form method="POST" action="{{ route('add_shepherd') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col s5">
                                <input id="shepherd_name" name="name" type="text" oninput="validName(this.value)">
                                <label for="name">Név</label>
                                <blockquote id="name_text"></blockquote>
                            </div>
                            <div class="input-field col s5">
                                <input id="shepherd_id" name="id" type="number" oninput="validId(this.value)">
                                <label for="id">Azonosító</label>
                                <blockquote id="id_text"></blockquote>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect" type="submit">Hozzáadás</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <h5>Új csorda hozzáadása</h5>
                    <form method="POST" action="{{ route('add_herd') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col s5">
                                <input name="name" type="text">
                                <label for="name">Név</label>
                            </div>
                            <div class="input-field col s5">
                                <input id="camel_count" name="camel_count" type="number">
                                <label for="id">Hány tevéből áll?</label>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect" type="submit">Hozzáadás</button>
                            </div>
                        </div>
                    </form>
                </div>
                @if (\Session::has('success'))
                    <script>M.toast({html: 'Hozzáadva!'})</script>
                @endif
            </div>
        </div>
    </div>
</body>

</html>