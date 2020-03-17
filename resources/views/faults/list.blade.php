<div id="faults-table"></div>
<script src="js/moment.min.js"></script>
<script type="application/javascript">
    $(document).ready(function () {
        function status_translate(cell) {
            if (typeof cell !== "string") {
                cell = cell.getValue();
            }
            const translations = {
                {{ App\FaultsTable::UNSEEN }}: "@lang('faults.unseen')",
                {{ App\FaultsTable::SEEN }}: "@lang('faults.seen')",
                {{ App\FaultsTable::DONE }}: "@lang('faults.done')",
                {{ App\FaultsTable::WONT_FIX }}: "@lang('faults.wont_fix')"
            };
            const colors = {
                {{ App\FaultsTable::UNSEEN }}: "",
                {{ App\FaultsTable::SEEN }}: "",
                {{ App\FaultsTable::DONE }}: "coli-text text-orange",
                {{ App\FaultsTable::WONT_FIX }}: "coli-text text-blue"
            };
            return '<div class="font-italic ' + colors[cell] + '">' + translations[cell] + '</div>';
        }

        var button = function (cell, formatterParams) {
            switch (formatterParams['status']) {
                case "{{ App\FaultsTable::DONE }}":
                    var style = "btn waves-effect";
                    var text = "@lang('faults.done')";
                    break;
            
                case "{{ App\FaultsTable::WONT_FIX }}":
                    var style = "waves-effect btn coli blue";
                    var text = "@lang('faults.wont_fix')";
                    break;
                
                case "{{ App\FaultsTable::UNSEEN }}":
                    var style = "btn-flat waves-effect grey lighten-4 ";
                    var text = "@lang('faults.reopen')";
                    break;
            }

            return $("<button type=\"button\" class=\"btn " + style + "\">" + text + "</button>").click(function () {
                var data = cell.getRow().getData();
                //confirm('@lang('internet.delete')', '@lang('internet.confirm_delete')', '@lang('internet.cancel')', '@lang('internet.delete')', function () {
                    $.post("{{ route('faults.update') }}", {id: data.id, status: formatterParams['status']}, function(data){
                        if (data !== "true"){
                            alert('@lang('faults.autherror')');
                        } else {
                            window.location.reload(true);
                        }
                    });
                //});
            })[0];
        };

        var button_formatter = function (cell, formatterParams, onRendered) {
            var status = cell.getRow().getData()["status"];

            switch (formatterParams['status']) {
                case "{{ App\FaultsTable::DONE }}":
                    if (status === "{{ App\FaultsTable::SEEN }}" || status === "{{ App\FaultsTable::UNSEEN }}") {
                        return button(cell, formatterParams);
                    }
                    break;

                case "{{ App\FaultsTable::WONT_FIX }}":
                    if (status === "{{ App\FaultsTable::UNSEEN }}") {
                        onRendered(function () {
                            $.post("{{ route('faults.update') }}", {id: cell.getValue(), status: "{{ App\FaultsTable::SEEN }}"}, );
                        });
                    }
                    if (status === "{{ App\FaultsTable::SEEN }}" || status === "{{ App\FaultsTable::UNSEEN }}") {
                        return button(cell, formatterParams);
                    } else {
                        return status_translate(status);
                    }
                    break;

                case "{{ App\FaultsTable::UNSEEN }}":
                    if (status === "{{ App\FaultsTable::DONE }}" || status === "{{ App\FaultsTable::WONT_FIX }}") {
                        return button(cell, formatterParams);
                    }
                    break;
            }

            return "";
        }

        var table = new Tabulator("#faults-table", {
            paginationSize: 10,
            pagination: "local", //enable remote pagination
            ajaxURL: "{{ route('faults.table') }}", //set url for ajax request
            ajaxFiltering: true,
            layout: "fitColumns",
            placeholder: "@lang('internet.nothing_to_show')",
            columns: [
                {title: "@lang('faults.created_at')", field: "created_at", sorter: "datetime", sorterParams: {format: "YYYY-MM-DD HH:mm:ss"}, width: 180,
                 formatter: "datetime", formatterParams: {outputFormat: "YYYY. MM. DD. HH:mm"}},
                {title: "@lang('faults.location')", field: "location", sorter: "string", widthGrow: 2, formatter: "textarea"},
                {title: "@lang('faults.description')", field: "description", sorter: "string", widthGrow: 3, formatter: "textarea"},
                @if(Auth::User()->hasRole(\App\Role::STAFF))
                {title: "", field: "id", headerSort: false, width: 100, formatter: button_formatter, formatterParams: {status: "{{ App\FaultsTable::DONE }}"}},
                {title: "", field: "id", headerSort: false, width: 200, formatter: button_formatter, formatterParams: {status: "{{ App\FaultsTable::WONT_FIX }}"}},
                @else
                {title: "@lang('faults.status')", field: "status", sorter: "string", width: 150, formatter: status_translate},
                @endif
                {title: "", field: "id", headerSort: false, width: 130, formatter: button_formatter, formatterParams: {status: "{{ App\FaultsTable::UNSEEN }}"}}
            ],
            initialSort: [
                {column: "created_at", dir: "desc"}
            ]
        });
    });
</script>
