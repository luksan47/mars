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
    <script type="text/javascript" src="{{ asset('js/camelbreeder.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
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
    </script>
</head>

<body>
    <div class="row" {{--style="height: 90vh; align-items: center;display: flex;"--}}>
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
                                <input id="shepherd_name" name="name" type="text" oninput="isInvalidName(this.value)">
                                <label for="name">Név</label>
                                <blockquote id="name_text"></blockquote>
                            </div>
                            <div class="input-field col s5">
                                <input id="shepherd_id" name="id" type="number" oninput="isInvalidId(this.value)">
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
                <div class="row">
                    <h5>Pásztor módosítása</h5>
                    <form method="POST" action="{{ route('add_herd') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col s5">
                                <input type="text" id="shepherd" name="id" class="shepherd_autocomplete"
                                    onchange="shepherdInfo(this.value, 'shepherd')">
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
                            <div class="input-field col s5">
                                <input id="min_camels" name="min_camels" type="number" value="{{env('CAMEL_MIN', -500)}}">
                                <label for="min_camels">Minimum tevék száma</label>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect" type="submit">módosítás</button>
                            </div>
                        </div>
                    </form>
                </div>
                @if (\Session::has('success'))
                    <script>M.toast({html: 'Hozzáadva!'})</script>
                @endif
                <h5>Tevenevelések</h5>
                <table>
                    <tbody>
                    <tr>
                        <th>shepherd</th>
                        <th>herd</th>
                        <th>date</th>
                    </tr>
                    @foreach($shepherdings as $sh)
                    <tr>
                        <td>{{ $sh->shepherd }}</td>
                        <td>{{ $sh->herd }}</td>
                        <td>{{ $sh->created_at }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <h5>Pásztorok</h5>
                <table>
                    <tbody>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>camels</th>
                        <th>min_camels</th>
                    </tr>
                    @foreach($shepherds as $shepherd)
                    <tr>
                        <td>{{ $shepherd->id }}</td>
                        <td>{{ $shepherd->name }}</td>
                        <td>{{ $shepherd->camels }}</td>
                        <td>{{ $shepherd->min_camels }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <h5>Csordák</h5>
                <table>
                    <tbody>
                    <tr>
                        <th>name</th>
                        <th>camels</th>
                        <th></th>
                    </tr>
                    @foreach($herds as $herd)
                    <form method="POST" action="{{ route('change_herd') }}">
                        @csrf
                        <tr>
                            <td>{{ $herd->name }}</td>
                            <input type="hidden" name="name" value="{{ $herd->name }}">
                            <td><input type="number" name="camel_count" value="{{ $herd->camel_count }}"></td>
                            <td><button class="btn waves-effect" type="submit">Módosítás</button></td>
                        </tr>
                    </form>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>