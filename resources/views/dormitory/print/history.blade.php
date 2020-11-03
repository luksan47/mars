<script type="text/javascript" src="{{ mix('js/moment.min.js') }}"></script>
<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.history')</span>
        <div id="print-history-table"></div>
        <script type="application/javascript">
        $(document).ready(function() {
            var deleteButton = function(cell, formatterParams, onRendered) {
                return $(
                    "<button type=\"button\" class=\"btn waves-effect btn-fixed-height  coli blue\">@lang('print.cancel_job')</button>"
                    ).click(function() {
                        var data = cell.getRow().getData();
                        // confirm('@lang('print.cancel_job')','@lang('print.confirm_cancel')','@lang('print.cancel')','@lang('print.cancel_job')',function() {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('print.print_jobs.cancel', [':id']) }}".replace(':id', data.id),
                                success: function() {
                                    cell.getTable().setPage(cell.getTable().getPage());
                                },
                                error: function(error) {
                                    ajaxError(
                                        '@lang('internet.error')',
                                        '@lang('internet.ajax_error')',
                                        '@lang('internet.ok')',
                                        error
                                    );
                                }
                            });
                        // });
                    })[0];
            };
            var dateFormatter = function(cell, formatterParams){
                var value = cell.getValue();
                if(value){
                    value = moment(value).format("YYYY. MM. DD. HH:mm");
                }
                return value;
            }
            var table = new Tabulator("#print-history-table", {
                paginationSize: 10,
                layout: "fitColumns",
                pagination: "remote", //enable remote pagination
                ajaxURL: "{{ $route }}", //set url for ajax request
                ajaxSorting: true,
                ajaxFiltering: true,
                placeholder: "@lang('internet.nothing_to_show')",
                headerSort: false,
                columnMinWidth:200,
                columns: [{
                        title: "@lang('internet.created_at')",
                        field: "created_at",
                        sorter: "datetime",
                        formatter:dateFormatter,
                        @can('viewAny', App\Models\PrintJob::class) headerFilter: 'input' @endcan
                    },
                    @can('viewAny', App\Models\PrintJob::class)
                    {
                        title: "@lang('print.user')",
                        field: "user.name",
                        sorter: "string",
                        headerFilter: 'input'
                    },
                    @endcan
                    {
                        title: "@lang('print.document')",
                        field: "filename",
                        sorter: "string",
                        @can('viewAny', App\Models\PrintJob::class) headerFilter: 'input' @endcan
                    },
                    {
                        title: "@lang('print.cost')",
                        field: "cost",
                        sorter: "string",
                        @can('viewAny', App\Models\PrintJob::class)  headerFilter: 'input' @endcan
                    },
                    {
                        title: "@lang('print.state')",
                        field: "state",
                        sorter: "string",
                        @can('viewAny', App\Models\PrintJob::class)
                        headerFilterParams: {
                            @foreach(\App\Models\PrintJob::STATES as $key => $state)
                            "{{ $state }}": "@lang('print.' . $state)",
                            @endforeach
                        }
                        @endcan
                    },
                    {
                        title: "Origin state",
                        field: "origin_state",
                        sorter: "string",
                        visible: false
                    },
                    {title: "", field: "id", headerSort: false, formatter: deleteButton},
                ],
                rowFormatter: function(row){
                    let colors = {
                        QUEUED: "blue",
                        CANCELLED: "yellow",
                        ERROR: "red",
                        SUCCESS: "green",
                    };

                    @foreach(\App\Models\PrintJob::STATES as $key => $state)
                        var existColor = "{{$state}}" in colors;
                        if (row.getData().origin_state == "{{$state}}" && existColor) {
                            const children = row.getElement().childNodes;
                            children.forEach((child) => {
                                child.style.backgroundColor = colors["{{$state}}"];
                            });
                        }
                    @endforeach
                }
            });
        });
        </script>

    </div>
</div>
