
<div id="mac-addresses-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
        var deleteButton = function (cell, formatterParams, onRendered) {
            return $("<button type=\"button\" class=\"btn waves-effect\">@lang('internet.delete')</button>").click(function () {
                var data = cell.getRow().getData();
                confirm('@lang('internet.delete')', '@lang('internet.confirm_delete')', '@lang('internet.cancel')', '@lang('internet.delete')', function() {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('internet.mac_addresses.delete', [':id']) }}".replace(':id', data.id),
                        success: function () {
                            cell.getTable().setPage(cell.getTable().getPage());
                        },
                        error: function(error) {
                            ajaxError('@lang('internet.error')', '@lang('internet.ajax_error')', '@lang('internet.ok')', error);
                        }
                    });
                });
            })[0];
        };
        var table = new Tabulator("#mac-addresses-table", {
            paginationSize: 10,
            layout:"fitColumns",
            autoresize:true,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('internet.mac_addresses.users') }}", //set url for ajax request
            ajaxSorting: true,
            ajaxFiltering: true,
            placeholder: "@lang('internet.nothing_to_show')",
            columnMinWidth:150,
            headerSort:false,
            columns: [
                {title: "@lang('internet.mac_address')", field: "mac_address", sorter: "string", @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) headerFilter: 'input' @endif},
                {title: "@lang('internet.comment')", field: "comment", sorter: "string", @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) headerFilter: 'input' @endif},
                {title: "@lang('internet.state')", field: "state", sorter: "string", @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) headerFilter: 'input' @endif},
                {title: "", field: "id", headerSort: false, formatter: deleteButton},
            ]
        });
    });
</script>
