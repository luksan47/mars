<div id="faults-table"></div>
<!-- TODO: revisit if moment js is necessary (hint: it's not, we just have to get rid of datetime sort in the table) -->
<script src="{{ mix('js/moment.min.js') }}"></script>
<script type="application/javascript">
    $(document).ready(function () {
        function status_translate(cell) {
            if (typeof cell !== "string") {
                cell = cell.getValue();
            }
            const translations = {
                {{ App\Models\Fault::UNSEEN }}: "@lang('faults.unseen')",
                {{ App\Models\Fault::SEEN }}: "@lang('faults.seen')",
                {{ App\Models\Fault::DONE }}: "@lang('faults.done')",
                {{ App\Models\Fault::WONT_FIX }}: "@lang('faults.wont_fix')"
            };
            const colors = {
                {{ App\Models\Fault::UNSEEN }}: "",
                {{ App\Models\Fault::SEEN }}: "",
                {{ App\Models\Fault::DONE }}: "coli-text text-orange",
                {{ App\Models\Fault::WONT_FIX }}: "coli-text text-blue"
            };
            return '<div class="font-italic ' + colors[cell] + '">' + translations[cell] + '</div>';
        }

        var button = function (cell, formatterParams) {
            switch (formatterParams['status']) {
                case "{{ App\Models\Fault::DONE }}":
                    var style = "btn waves-effect btn-fixed-height";
                    var text = "@lang('faults.done')";
                    break;
            
                case "{{ App\Models\Fault::WONT_FIX }}":
                    var style = "waves-effect btn coli blue btn-fixed-height";
                    var text = "@lang('faults.wont_fix')";
                    break;
                
                case "{{ App\Models\Fault::UNSEEN }}":
                    var style = "btn-flat waves-effect grey lighten-4 btn-fixed-height";
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
                case "{{ App\Models\Fault::DONE }}":
                    if (status === "{{ App\Models\Fault::SEEN }}" || status === "{{ App\Models\Fault::UNSEEN }}") {
                        return button(cell, formatterParams);
                    }
                    break;

                case "{{ App\Models\Fault::WONT_FIX }}":
                    if (status === "{{ App\Models\Fault::UNSEEN }}") {
                        onRendered(function () {
                            $.post("{{ route('faults.update') }}", {id: cell.getValue(), status: "{{ App\Models\Fault::SEEN }}"}, );
                        });
                    }
                    if (status === "{{ App\Models\Fault::SEEN }}" || status === "{{ App\Models\Fault::UNSEEN }}") {
                        return button(cell, formatterParams);
                    } else {
                        return status_translate(status);
                    }
                    break;

                case "{{ App\Models\Fault::UNSEEN }}":
                    if (status === "{{ App\Models\Fault::DONE }}" || status === "{{ App\Models\Fault::WONT_FIX }}") {
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
                @if(Auth::User()->hasRole(\App\Models\Role::STAFF))
                {title: "", field: "id", headerSort: false, width: 100, formatter: button_formatter, formatterParams: {status: "{{ App\Models\Fault::DONE }}"}},
                {title: "", field: "id", headerSort: false, width: 200, formatter: button_formatter, formatterParams: {status: "{{ App\Models\Fault::WONT_FIX }}"}},
                @else
                {title: "@lang('faults.status')", field: "status", sorter: "string", width: 150, formatter: status_translate},
                @endif
                {title: "", field: "id", headerSort: false, width: 130, formatter: button_formatter, formatterParams: {status: "{{ App\Models\Fault::UNSEEN }}"}}
            ],
            initialSort: [
                {column: "created_at", dir: "desc"}
            ]
        });
    });
</script>
