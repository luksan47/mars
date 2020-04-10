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
            height:"100%",
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
                        $.ajax({
                            url: "{{ route('camel_breeder.change_herd') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: cell.getRow().getData(),
                            type: "post",
                            success: function(response, textStatus, xhr){
                                M.toast({html: 'Sikeres módosítás!', classes: "white black-text"});
                            },
                        })
                    },
                },
            ],
        });
    });
</script>