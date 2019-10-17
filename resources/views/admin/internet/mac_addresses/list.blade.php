<div id="internet-accesses-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
        var actions = function (cell, formatterParams, onRendered) {
            var data = cell.getRow().getData();
            var changeState = function (state) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('internet.mac_addresses.edit', [':id']) }}".replace(':id', data.id),
                    data: {
                        'state': state
                    },
                    success: function (response) {
                        response = {...data, ...response};
                        cell.getTable().updateData([response]);
                        cell.getRow().reformat();
                    },
                    error: function (error) {
                        ajaxError('@lang('internet.error')', '@lang('internet.ajax_error')', '@lang('internet.ok')', error);
                    }
                });
            };

            return $("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-danger float-left\">@lang('internet.reject')</button>")
                .click(function () {
                changeState('rejected');
            }).toggle(data._state === '{{ \App\MacAddress::REQUESTED }}')
                .add($("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-success float-left\">@lang('internet.approve')</button>")
                    .click(function () {
                changeState('approved');
            }).toggle(data._state === '{{ \App\MacAddress::REQUESTED }}'))
                .add($("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-warning float-left\">@lang('internet.request')</button>")
                    .click(function () {
                changeState('requested');
            }).toggle(data._state !== '{{ \App\MacAddress::REQUESTED }}')).wrapAll('<div></div>').parent()[0];
        };

        var deleteButton = function (cell, formatterParams, onRendered) {
            return $("<button type=\"button\" class=\"btn btn-sm btn-danger float-left\">@lang('internet.delete')</button>").click(function () {
                var data = cell.getRow().getData();
                confirm('@lang('internet.delete')', '@lang('internet.confirm_delete')', '@lang('internet.cancel')', '@lang('internet.delete')', function () {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('internet.mac_addresses.delete', [':id']) }}".replace(':id', data.id),
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

        var table = new Tabulator("#internet-accesses-table", {
            paginationSizeSelector: [10, 25, 50, 100, 250, 500],
            paginationSize: 10,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('internet.admin.mac_addresses.all') }}", //set url for ajax request
            ajaxSorting: true,
            ajaxFiltering: true,
            layout: "fitColumns",
            placeholder: "No Data Set",
            columns: [
                {
                    title: "@lang('internet.username')",
                    field: "user.name",
                    sorter: "string",
                    headerFilter: 'input'
                },
                {
                    title: "@lang('internet.mac_address')",
                    field: "mac_address",
                    sorter: "string",
                    headerFilter: 'input'
                },
                {title: "@lang('internet.comment')", field: "comment", sorter: "string", headerFilter: 'input'},
                {
                    title: "@lang('internet.created_at')",
                    field: "created_at",
                    sorter: "datetime",
                    headerFilter: 'input'
                },
                {
                    title: "@lang('internet.state')", field: "state", sorter: "string", headerFilter: 'select',
                    headerFilterParams: {
                        "rejected": "@lang('internet.rejected')",
                        "approved": "@lang('internet.approved')",
                        "requested": "@lang('internet.requested')"
                    }
                },
                {title: "", field: "state", headerSort: false, formatter: actions},
                {title: "", field: "id", headerSort: false, formatter: deleteButton},
            ],
        });
    });
</script>
