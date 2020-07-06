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
            height:"100%",
            placeholder: "Nincs ilyen tevenevelés :(",
            columns: [
                {
                    title: "Pásztor",
                    field: "name",
                    sorter: "string",
                    headerFilter: 'input',
                    bottomCalc: "count"
                },
                {
                    title: "Pásztor azonosító",
                    field: "id",
                    sorter: "number",
                    headerFilter: "number",
                },
                {
                    title: "Csorda",
                    field: "herd",
                    sorter: "string",
                    headerFilter:"input"
                },
                {
                    title: "Tevék",
                    field: "camels",
                    sorter: "number",
                    headerFilter: "number",
                    bottomCalc: "sum"
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