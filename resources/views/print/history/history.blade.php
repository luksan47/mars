<div class="card">
    <div class="card-header">@lang('print.history')</div>
    <div class="card-body">
    <div id="print-history-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
        
        var deleteButton = function (cell, formatterParams, onRendered) {
            return $("<button type=\"button\" class=\"btn btn-sm btn-danger float-left\">@lang('print.cancel_job')</button>").click(function () {
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
            paginationSizeSelector: [10, 25, 50, 100, 250, 500],
            paginationSize: 10,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('print.print_jobs.all') }}", //set url for ajax request
            ajaxSorting: true,
            ajaxFiltering: true,
            layout: "fitColumns",
            placeholder: "No Data Set",
            columns: [
                {
                    title: "@lang('internet.created_at')",
                    field: "created_at",
                    sorter: "datetime",
                    headerFilter: 'input'
                },
                @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN))
                {
                    title: "@lang('print.user')",
                    field: "user.name",
                    sorter: "string",
                    headerFilter: 'input'
                },
                @endif
                {
                    title: "@lang('print.document')",
                    field: "filename",
                    sorter: "string",
                    headerFilter: 'input'
                },
                {
                    title: "@lang('print.cost')",
                    field: "cost",
                    sorter: "string",
                    headerFilter: 'input'
                },
                {
                    title: "@lang('print.state')", field: "state", sorter: "string", headerFilter: 'select',
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