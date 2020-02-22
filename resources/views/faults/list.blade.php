<div id="faults-table"></div>
<script src="js/moment.min.js"></script>
<script type="application/javascript">
    $(document).ready(function () {
        function status_translate(cell) {
            if (typeof cell !== "string") {
                cell = cell.getValue();
            }
            var translations = {
                UNSEEN: "@lang('faults.unseen')",
                SEEN: "@lang('faults.seen')",
                DONE: "@lang('faults.done')",
                WONT_FIX: "@lang('faults.wont_fix')"
            };
            var colors = {
                UNSEEN: "text-secondary",
                SEEN: "text-info",
                DONE: "text-success",
                WONT_FIX: "text-danger"
            };
            return '<div class="font-italic ' + colors[cell] + ' text-right">' + translations[cell] + '</div>';
        }

        var button = function (cell, formatterParams) {
            if (formatterParams['status'] === "DONE") {
                var style = "btn-success";
                var text = "@lang('faults.done')";
            } else if (formatterParams['status'] === "WONT_FIX") {
                var style = "btn-danger";
                var text = "@lang('faults.wont_fix')";
            } else if (formatterParams['status'] === "UNSEEN") {
                var style = "btn-danger";
                var text = "@lang('faults.reopen')";
            }
            return $("<button type=\"button\" class=\"btn btn-sm " + style + " float-left\">" + text + "</button>").click(function () {
                var data = cell.getRow().getData();
                var returned;
                confirm('@lang('faults.confirm')', '@lang('faults.confirm_message')' + text, '@lang('faults.cancel')', '@lang('faults.confirm')', function() {
                    $.post("{{ route('faults.update') }}", {id: data.id, status: formatterParams['status']}, function(data){
                        if (data !== "true"){
                            alert('@lang('faults.autherror')');
                        } else {
                            window.location.reload(true);
                        }
                    });
                });
            })[0];
        };

        var button_formatter = function (cell, formatterParams, onRendered) {
            var status = cell.getRow().getData()["status"];
            if (formatterParams["status"] === "UNSEEN") {
                if (status === "DONE" || status === "WONT_FIX") {
                    return button(cell, formatterParams);
                } else {
                    return "";
                }
            }
            if (status === "UNSEEN" && formatterParams["status"] === "WONT_FIX") {
                onRendered(function () {
                    $.post("{{ route('faults.update') }}", {id: cell.getValue(), status: "SEEN"}, );
                });
                return button(cell, formatterParams);
            } else if (status === "SEEN" || status === "UNSEEN") {
                return button(cell, formatterParams);
            } else if (formatterParams["status"] === "WONT_FIX") {
                return status_translate(status);
            }
            return "";
        }

        var table = new Tabulator("#faults-table", {
            paginationSizeSelector: [10, 25, 50, 100, 250, 500],
            paginationSize: 10,
            pagination: "local", //enable remote pagination
            ajaxURL: "{{ route('faults.table') }}", //set url for ajax request
            ajaxFiltering: true,
            layout: "fitColumns",
            placeholder: "No Data Set",
            columns: [
                {title: "@lang('faults.created_at')", field: "created_at", sorter: "datetime", sorterParams: {format: "YYYY-MM-DD HH:mm:ss"}, width: 180,
                 formatter: "datetime", formatterParams: {outputFormat: "YYYY. MM. DD. HH:mm"}},
                {title: "@lang('faults.location')", field: "location", sorter: "string", widthGrow: 1, formatter: "textarea"},
                {title: "@lang('faults.description')", field: "description", sorter: "string", widthGrow: 4, formatter: "textarea"},
                @if(Auth::User()->hasRole(\App\Role::INTERNET_ADMIN))
                {title: "", field: "id", headerSort: false, width: 60, formatter: button_formatter, formatterParams: {status: "DONE"}},
                {title: "", field: "id", headerSort: false, width: 140, formatter: button_formatter, formatterParams: {status: "WONT_FIX"}},
                @else
                {title: "@lang('faults.status')", field: "status", sorter: "string", width: 140, formatter: status_translate},
                @endif
                {title: "", field: "id", headerSort: false, width: 60, formatter: button_formatter, formatterParams: {status: "UNSEEN"}}
            ],
            initialSort: [
                {column: "created_at", dir: "desc"}
            ]
        });
    });
</script>
