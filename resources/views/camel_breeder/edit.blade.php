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
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
    /*
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
    */
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

        //get herds
        var xmlhttp_herds = new XMLHttpRequest();
        xmlhttp_herds.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.herds = JSON.parse(this.responseText);
        }};
        xmlhttp_herds.open("GET", "send_herds", true);
        xmlhttp_herds.send();
        
        //get shepherds
        var xmlhttp_shepherds = new XMLHttpRequest();
        xmlhttp_shepherds.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.shepherds = JSON.parse(this.responseText);
        }};
        xmlhttp_shepherds.open("GET", "send_shepherds", true);
        xmlhttp_shepherds.send();
    });
    $(document).ajaxError(function(){
        alert("An ajax error occurred!");
    });
    </script>
</head>

<body>
    <div class="row" style="margin-top:50px;">
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
                    <div class="col s12" style="margin-bottom: 20px">
                      <ul class="tabs">
                        <li class="tab col s4"><a href="#csordak">Csordák</a></li>
                        <li class="tab col s4"><a href="#pasztorok">Pásztorok</a></li>
                        <li class="tab col s4"><a href="#nevelesek">Tevenevelések</a></li>
                      </ul>
                    </div>
                    <div id="csordak" class="col s12">
                        <div id="herds"></div>
                        <script type="application/javascript">
                            $(document).ready(function () {
                                //custom max min header filter
                                var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){
                                var end;
                                var container = document.createElement("span");
                                //create and style inputs
                                var start = document.createElement("input");
                                start.setAttribute("type", "number");
                                start.setAttribute("placeholder", "Min");
                                start.setAttribute("min", 0);
                                start.setAttribute("max", 100);
                                start.style.padding = "4px";
                                start.style.width = "48%";
                                start.style.marginRight = "5px";
                                start.style.boxSizing = "border-box";

                                start.value = cell.getValue();

                                function buildValues(){
                                    success({
                                        start:start.value,
                                        end:end.value,
                                    });
                                }
                                function keypress(e){
                                    if(e.keyCode == 13){
                                        buildValues();
                                    }

                                    if(e.keyCode == 27){
                                        cancel();
                                    }
                                }
                                end = start.cloneNode();
                                end.setAttribute("placeholder", "Max");

                                start.addEventListener("change", buildValues);
                                start.addEventListener("blur", buildValues);
                                start.addEventListener("keydown", keypress);

                                end.addEventListener("change", buildValues);
                                end.addEventListener("blur", buildValues);
                                end.addEventListener("keydown", keypress);

                                container.appendChild(start);
                                container.appendChild(end);

                                return container;
                                }

                                //custom max min filter function
                                function minMaxFilterFunction(headerValue, rowValue, rowData, filterParams){
                                //headerValue - the value of the header filter element
                                //rowValue - the value of the column in this row
                                //rowData - the data for the row being filtered
                                //filterParams - params object passed to the headerFilterFuncParams property

                                    if(rowValue){
                                        if(headerValue.start != ""){
                                            if(headerValue.end != ""){
                                                return rowValue >= headerValue.start && rowValue <= headerValue.end;
                                            }else{
                                                return rowValue >= headerValue.start;
                                            }
                                        }else{
                                            if(headerValue.end != ""){
                                                return rowValue <= headerValue.end;
                                            }
                                        }
                                    }

                                return true; //must return a boolean, true if it passes the filter.
                                }
                                var table = new Tabulator("#herds", {
                                    paginationSize: 10,
                                    ajaxURL: "{{ route('camel_breeder.send_herds') }}", //set url for ajax request
                                    ajaxContentType:"json",
                                    pagination:"local",
                                    paginationSize:10,
                                    layout:"fitColumns",
                                    placeholder: "Nincsenek csordák :(",
                                    columns: [
                                        {
                                            title: "Név",
                                            field: "name",
                                            sorter: "string",
                                            headerFilter: 'input',
                                        },
                                        {
                                            title: "Hány tevéből áll?",
                                            field: "camel_count",
                                            sorter: "number",
                                            headerFilter:minMaxFilterEditor, 
                                            headerFilterFunc:minMaxFilterFunction,
                                            cssClass:"italic",
                                            editor:"number",
                                            cellEdited:function(cell){
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });
                                                $.ajax({
                                                    url: "{{ route('camel_breeder.change_herd') }}",
                                                    data: cell.getRow().getData(),
                                                    type: "post",
                                                    success: function(response, textStatus, xhr){
                                                        M.toast({html: 'Sikeres módosítás!'});
                                                    },
                                                })
                                            },
                                        },
                                    ],
                                });
                            });
                        </script>
                    </div>
                    <div id="pasztorok" class="col s12">
                        <div id="shepherds"></div>
                        <script type="application/javascript">
                            $(document).ready(function () {
                                //custom max min header filter
                                var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){
                                var end;
                                var container = document.createElement("span");
                                //create and style inputs
                                var start = document.createElement("input");
                                start.setAttribute("type", "number");
                                start.setAttribute("placeholder", "Min");
                                start.setAttribute("min", 0);
                                start.setAttribute("max", 100);
                                start.style.padding = "4px";
                                start.style.width = "48%";
                                start.style.marginRight = "5px";
                                start.style.boxSizing = "border-box";

                                start.value = cell.getValue();

                                function buildValues(){
                                    success({
                                        start:start.value,
                                        end:end.value,
                                    });
                                }
                                function keypress(e){
                                    if(e.keyCode == 13){
                                        buildValues();
                                    }

                                    if(e.keyCode == 27){
                                        cancel();
                                    }
                                }
                                end = start.cloneNode();
                                end.setAttribute("placeholder", "Max");

                                start.addEventListener("change", buildValues);
                                start.addEventListener("blur", buildValues);
                                start.addEventListener("keydown", keypress);

                                end.addEventListener("change", buildValues);
                                end.addEventListener("blur", buildValues);
                                end.addEventListener("keydown", keypress);

                                container.appendChild(start);
                                container.appendChild(end);

                                return container;
                                }

                                //custom max min filter function
                                function minMaxFilterFunction(headerValue, rowValue, rowData, filterParams){
                                //headerValue - the value of the header filter element
                                //rowValue - the value of the column in this row
                                //rowData - the data for the row being filtered
                                //filterParams - params object passed to the headerFilterFuncParams property

                                    if(rowValue){
                                        if(headerValue.start != ""){
                                            if(headerValue.end != ""){
                                                return rowValue >= headerValue.start && rowValue <= headerValue.end;
                                            }else{
                                                return rowValue >= headerValue.start;
                                            }
                                        }else{
                                            if(headerValue.end != ""){
                                                return rowValue <= headerValue.end;
                                            }
                                        }
                                    }

                                return true; //must return a boolean, true if it passes the filter.
                                }
                                var table = new Tabulator("#shepherds", {
                                    paginationSize: 10,
                                    ajaxURL: "{{ route('camel_breeder.send_shepherds') }}", //set url for ajax request
                                    ajaxContentType:"json",
                                    pagination:"local",
                                    paginationSize:10,
                                    layout:"fitColumns",
                                    initialFilter:[{field:"id", type:"!=", value:"0"}],
                                    placeholder: "Nincs ilyen pásztor :(",
                                    columns: [
                                        {
                                            title: "Pásztor",
                                            field: "name",
                                            sorter: "string",
                                            headerFilter: 'input',
                                            bottomCalc:"count"
                                        },
                                        {
                                            title: "Pásztor azonosító",
                                            field: "id",
                                            sorter: "number",
                                            headerFilter: 'input',
                                        },
                                        {
                                            title: "Tevéi",
                                            field: "camels",
                                            sorter:"number", 
                                            headerFilter:minMaxFilterEditor, 
                                            headerFilterFunc:minMaxFilterFunction,
                                            bottomCalc:"sum"
                                        },
                                        {
                                            title: "Minimum tevéi",
                                            field: "min_camels",
                                            sorter: "number",
                                            headerFilter:minMaxFilterEditor, 
                                            headerFilterFunc:minMaxFilterFunction,
                                            cssClass:"italic",
                                            editor:"number",
                                            cellEdited:function(cell){
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });
                                                $.ajax({
                                                    url: "{{ route('camel_breeder.change_shepherd') }}",
                                                    data: cell.getRow().getData(),
                                                    type: "post",
                                                    success: function(response, textStatus, xhr){
                                                        M.toast({html: 'Sikeres módosítás!'});
                                                    },
                                                })
                                            },
                                        },
                                    ],
                                });
                            });
                        </script>
                    </div>
                    <div id="nevelesek" class="col s12">
                        <div id="shepherdings"></div>
                        <script type="application/javascript">
                            $(document).ready(function () {
                                //custom header filter
                                var dateFilterEditor = function(cell, onRendered, success, cancel, editorParams){

                                var container = $("<span></span>")
                                //create and style input
                                var start = $("<input type='date' placeholder='Start'/>");
                                var end = $("<input type='date' placeholder='End'/>");

                                container.append(start).append(end);

                                var inputs = $("input", container);


                                inputs.css({
                                    "padding":"4px",
                                    "marginRight":"5px",
                                    "width":"48%",
                                    "box-sizing":"border-box",
                                })
                                .val(cell.getValue());

                                function buildDateString(){
                                    return {
                                        start:start.val(),
                                        end:end.val(),
                                    };
                                }

                                //submit new value on blur
                                inputs.on("change blur", function(e){
                                    success(buildDateString());
                                });

                                //submit new value on enter
                                inputs.on("keydown", function(e){
                                    if(e.keyCode == 13){
                                        success(buildDateString());
                                    }

                                    if(e.keyCode == 27){
                                        cancel();
                                    }
                                });

                                return container[0];
                                }

                                //custom filter function
                                function dateFilterFunction(headerValue, rowValue, rowData, filterParams){
                                //headerValue - the value of the header filter element
                                //rowValue - the value of the column in this row
                                //rowData - the data for the row being filtered
                                //filterParams - params object passed to the headerFilterFuncParams property

                                var format = filterParams.format || "YYYY-MM-DD";
                                var start = moment(headerValue.start);
                                var end = moment(headerValue.end);
                                var value = moment(rowValue, format);
                                if(rowValue){
                                    if(start.isValid()){
                                        if(end.isValid()){
                                            return value >= start && value <= end;
                                        }else{
                                            return value >= start;
                                        }
                                    }else{
                                        if(end.isValid()){
                                            return value <= end;
                                        }
                                    }
                                }

                                return false; //must return a boolean, true if it passes the filter.
                                }
                                var table = new Tabulator("#shepherdings", {
                                    paginationSize: 10,
                                    ajaxURL: "{{ route('camel_breeder.send_shepherdings') }}", //set url for ajax request
                                    ajaxContentType:"json",
                                    layout:"fitColumns",
                                    pagination:"local",
                                    paginationSize:10,
                                    placeholder: "Nincs ilyen tevenevelés :(",
                                    columns: [
                                        {
                                            title: "Pásztor",
                                            field: "name",
                                            sorter: "string",
                                            headerFilter: 'input',
                                            bottomCalc:"count"
                                        },
                                        {
                                            title: "Pásztor azonosító",
                                            field: "id",
                                            sorter: "number",
                                            headerFilter: 'input',
                                        },
                                        {
                                            title: "Csorda",
                                            field: "herd",
                                            sorter: "string",
                                            headerFilter:"input"
                                        },
                                        {
                                            title: "Dátum",
                                            field: "created_at",
                                            sorter: "string",
                                            widthGrow:1.2,
                                            minWidth:350,
                                            headerFilter:dateFilterEditor, 
                                            headerFilterFunc:dateFilterFunction
                                        },
                                    ],
                                    initialSort: [
                                        {column: "created_at", dir: "desc"}
                                    ]
                                });
                            });
                        </script>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>

</html>