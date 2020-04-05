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
    <link rel="stylesheet" href="{{ asset('css/tabulator_materialize.min.css') }}">
    <!-- materialize css generated from resources/sass/materialize.scss-->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.css') }}" media="screen,projection" />

    <!-- Scripts -->
    <script src="{{ asset('js/tabulator.min.js') }}" defer></script>
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
    $(document).ready(function(){
        $('.tabs').tabs({
            swipeable: true,
        });
        $('input.shepherd_search_autocomplete').autocomplete({
            data: {
                @foreach($shepherds as $shepherd)
                "{{$shepherd -> name}}": null,
                {{$shepherd -> id}}: null,
                @endforeach
            },
        });
        $('input.herd_search_autocomplete').autocomplete({
            data: {
                @foreach($herds as $herd)
                "{{$herd -> name}}": null,
                @endforeach
            }
        });
        @if (\Session::has('success'))
        M.toast({html: 'Sikeres módosítás!'});
        @endif
    });
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
                    <form method="POST" action="{{ route('camel_breeder.add_shepherd') }}">
                        @csrf
                        <div class="row">
                            <div class="input-field col s4">
                                <input id="shepherd_name" name="name" type="text" oninput="isInvalidName(this.value)">
                                <label for="name">Név</label>
                                <blockquote id="name_text"></blockquote>
                            </div>
                            <div class="input-field col s4">
                                <input id="shepherd_id" name="id" type="number" oninput="isInvalidId(this.value)">
                                <label for="id">Azonosító</label>
                                <blockquote id="id_text"></blockquote>
                            </div>
                            <div class="input-field col s2">
                                <input name="camels" type="number">
                                <label for="camels">Kezdő teveszám</label>
                            </div>
                            <div class="input-field col s2">
                                <button class="btn waves-effect" type="submit">Hozzáadás</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <h5>Új csorda hozzáadása</h5>
                    <form method="POST" action="{{ route('camel_breeder.add_herd') }}">
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
                    <form method="POST" action="{{ route('camel_breeder.change_shepherd') }}">
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

                <div class="row">
                    <div class="col s12" style="margin-bottom: 20px">
                      <ul class="tabs">
                        <li class="tab col s4"><a href="#csordak">Csordák</a></li>
                        <li class="tab col s4"><a href="#pasztorok">Pásztorok</a></li>
                        <li class="tab col s4"><a href="#nevelesek">Tevenevelések</a></li>
                      </ul>
                    </div>
                    <div id="csordak" class="col s12">
                        <table>
                            <tbody>
                            <tr>
                                <th>Név</th>
                                <th>Tevék</th>
                                <th></th>
                            </tr>
                            @foreach($herds as $herd)
                            <form method="POST" action="{{ route('camel_breeder.change_herd') }}">
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
                    <div id="history"></div>
                    <script type="application/javascript">
                        $(document).ready(function () {
                            var table = new Tabulator("#history", {
                                paginationSize: 20,
                                pagination: "remote", //enable remote pagination
                                ajaxURL: "{{ route('camel_breeder.history') }}", //set url for ajax request
                                ajaxContentType:"json",
                                ajaxSorting: true,
                                ajaxFiltering: true,
                                layout:"fitColumns",
                                placeholder: "No Data Set",
                                columns: [
                                    {
                                        title: "Pásztor",
                                        field: "shepherd",
                                        sorter: "number",
                                        headerFilter: 'input'
                                    },
                                    {
                                        title: "Csorda",
                                        field: "herd",
                                        sorter: "string",
                                        headerFilter: 'input'
                                    },
                                ],
                            });
                        });
                    </script>
                    <div id="pasztorok" class="col s12">
                        <table>
                            <tbody>
                            <tr>
                                <th>Azonosító</th>
                                <th>Név</th>
                                <th>Tevék</th>
                                <th>Minimum tevék</th>
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
                    </div>
                    <div id="nevelesek" class="col s12">
                        <form method="GET" action="">
                            @csrf
                            <div class="row">
                                <div class="input-field col s3">
                                    <input type="text" id="shepherd_search" name="id" class="shepherd_search_autocomplete"
                                        onchange="shepherdInfo(this.value, 'shepherd_search')">
                                    <label for="id">Pásztor</label>
                                    <blockquote id="shepherd_search_text"></blockquote>
                                </div>
                                <div class="input-field col s3">
                                    <input type="text" id="herd_search" class="herd_search_autocomplete"> 
                                    <label for="herd">Tevecsorda</label>
                                </div>
                                <div class="input-field col s2">
                                    <input type="text" class="datepicker_from" id="from_date" name="from_date"
                                        onfocus="M.Datepicker.getInstance(from_date).open();">
                                    <label for="from_date">Ettől</label>
                                    <script>
                                    $(document).ready(function() {
                                        $('.datepicker_from').datepicker({
                                            format: 'yyyy-mm-dd',
                                            firstDay: 1,
                                            yearRange: 10,
                                            maxDate: new Date(),
                                        });
                                    });
                                    </script>
                                </div>
                                <div class="input-field col s2">
                                    <input type="text" class="datepicker_to" id="to_date" name="to_date"
                                        onfocus="M.Datepicker.getInstance(to_date).open();">
                                    <label for="from_date">Eddig</label>
                                    <script>
                                    $(document).ready(function() {
                                        $('.datepicker_to').datepicker({
                                            format: 'yyyy-mm-dd',
                                            firstDay: 1,
                                            yearRange: 10,
                                            maxDate: new Date(),
                                            defaultDate: new Date(),
                                        });
                                    });
                                    </script>
                                </div>
                                <div class="input-field col s2">
                                    <button class="btn waves-effect" type="submit">Keresés</button>
                                </div>
                            </div>
                        </form>
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
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>

</html>