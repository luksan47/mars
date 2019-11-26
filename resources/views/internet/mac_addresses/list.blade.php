<div id="mac-addresses-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
        var deleteButton = function (cell, formatterParams, onRendered) {
            return $("<button type=\"button\" class=\"btn btn-sm btn-danger float-left\">@lang('internet.delete')</button>").click(function () {
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
            paginationSizeSelector: [10, 25, 50, 100, 250, 500],
            paginationSize: 10,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('internet.mac_addresses.users') }}", //set url for ajax request
            ajaxSorting: true,
            ajaxFiltering: true,
            layout: "fitColumns",
            placeholder: "No Data Set",
            columns: [
                {title: "@lang('internet.mac_address')", field: "mac_address", sorter: "string"},
                {title: "@lang('internet.comment')", field: "comment", sorter: "string"},
                {title: "@lang('internet.state')", field: "state", sorter: "string"},
                {title: "", field: "id", headerSort: false, formatter: deleteButton},
            ]
        });
    });
</script>
