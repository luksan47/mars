<div id="faults-table"></div>
<script src="js/moment.min.js"></script>
<script type="application/javascript">
    $(document).ready(function () {
        function status_translate(cell) {
            if (typeof cell !== "string") {
                cell = cell.getValue();
            }
            var translations = {
                unseen: "@lang('faults.unseen')",
                seen: "@lang('faults.seen')",
                done: "@lang('faults.done')",
                wont_fix: "@lang('faults.wont_fix')"
            };
            var colors = {
                unseen: "text-secondary",
                seen: "text-info",
                done: "text-success",
                wont_fix: "text-danger"
            };
            return '<div class="font-italic ' + colors[cell] + ' text-right">' + translations[cell] + '</div>';
        }

        var button = function (cell, formatterParams) {
            if (formatterParams['status'] === "done") {
                var style = "btn-success";
                var text = "@lang('faults.done')";
            } else {
                var style = "btn-danger";
                var text = "@lang('faults.wont_fix')";
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

        var custom_formatter = function (cell, formatterParams, onRendered) {
            var status = cell.getRow().getData()["status"];
            if (status === "unseen" && formatterParams["status"] === "wont_fix") {
                onRendered(function () {
                    console.log("most");
                    $.post("{{ route('faults.update') }}", {id: cell.getValue(), status: 'seen'}, );
                });
                console.log(status);
                return button(cell, formatterParams);
            } else if (status === "seen" || status === "unseen") {
                return button(cell, formatterParams);
            } else if (formatterParams["status"] === "wont_fix") {
                return status_translate(status);
            }
            return '';
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
                {title: "", field: "id", headerSort: false, width: 60, formatter: custom_formatter, formatterParams: {status: "done"}},
                {title: "", field: "id", headerSort: false, width: 140, formatter: custom_formatter, formatterParams: {status: "wont_fix"}}
                @else
                {title: "@lang('faults.status')", field: "status", sorter: "string", width: 140, formatter: status_translate}
                @endif
            ],
            initialSort: [
                {column: "created_at", dir: "desc"}
            ]
        });
    });
</script>
