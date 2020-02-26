<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.history')</span>
        <div id="print-history-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
        var deleteButton = function (cell, formatterParams, onRendered) {
            return $("<button type=\"button\" class=\"btn waves-effect secondary-color\">@lang('print.cancel_job')</button>").click(function () {
                var data = cell.getRow().getData();
                confirm('@lang('print.cancel_job')', '@lang('print.confirm_cancel')', '@lang('print.cancel')', '@lang('print.cancel_job')', function () {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('print.print_jobs.cancel', [':id']) }}".replace(':id', data.id),
                        success: function () {
                            cell.getTable().setPage(cell.getTable().getPage());
                        },
                        error: function (error) {
                            ajaxError('@lang('internet.error')', '@lang('internet.ajax_error')', '@lang('internet.ok')', error);
                        }
                    });
                });
            })[0];
        };

        var table = new Tabulator("#print-history-table", {
            paginationSize: 10,
            layout:"fitColumns",
            autoresize:true,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('print.print_jobs.all') }}", //set url for ajax request
            ajaxSorting: true,
            ajaxFiltering: true,
            placeholder: "@lang('internet.nothing_to_show')",
            columnMinWidth:150,
            headerSort:false,
            columns: [
                {
                    title: "@lang('internet.created_at')",
                    field: "created_at",
                    sorter: "datetime",
                },
                @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN))
                {
                    title: "@lang('print.user')",
                    field: "user.name",
                    sorter: "string",
                },
                @endif
                {
                    title: "@lang('print.document')",
                    field: "filename",
                    sorter: "string",
                },
                {
                    title: "@lang('print.cost')",
                    field: "cost",
                    sorter: "string",
                },
                {
                    title: "@lang('print.state')", field: "state", sorter: "string",
                    headerFilterParams: {
                        @foreach(\App\PrintJob::STATES as $key => $state)
                            "{{ $state }}": "@lang('print.' . $state)",
                        @endforeach
                    }
                },
               /* {title: "", field: "id", headerSort: false, formatter: deleteButton}, */
            ],
        });
    });
</script>

    </div>
</div>