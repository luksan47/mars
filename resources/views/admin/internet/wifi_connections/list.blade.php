<span class="card-title">@lang('internet.wifi_connections')</span>
<div id="wifi-connections-table"></div>
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

            return $("<button type=\"button\" style=\"margin: 2px;\" class=\"btn waves-effect coli blue\">@lang('internet.reject')</button></br>")
                .click(function () {
                changeState('rejected');
            }).toggle(data._state === '{{ \App\Models\MacAddress::REQUESTED }}')
                .add($("<button type=\"button\" style=\"margin: 2px;\" class=\"btn waves-effect\">@lang('internet.approve')</button></br>")
                    .click(function () {
                changeState('approved');
            }).toggle(data._state === '{{ \App\Models\MacAddress::REQUESTED }}'))
                .add($("<button type=\"button\" style=\"margin: 2px;\" class=\"btn waves-effect\">@lang('internet.request')</button></br>")
                    .click(function () {
                changeState('requested');
            }).toggle(data._state !== '{{ \App\Models\MacAddress::REQUESTED }}')).wrapAll('<div></div>').parent()[0];
        };

        var deleteButton = function (cell, formatterParams, onRendered) {
            return $("<button type=\"button\" class=\"btn waves-effect coli blue\">@lang('internet.delete')</button>").click(function () {
                var data = cell.getRow().getData();
                //confirm('@lang('internet.delete')', '@lang('internet.confirm_delete')', '@lang('internet.cancel')', '@lang('internet.delete')', function () {
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
                //});
            })[0];
        };

        var table = new Tabulator("#wifi-connections-table", {
            paginationSize: 10,
            pagination: "remote",
            ajaxURL: "{{ route('internet.admin.wifi_connections.all') }}",
            ajaxSorting: true,
            ajaxFiltering: true,
            layout:"fitColumns",
            placeholder: "No Data Set",
            columns: [
                {
                    title: "@lang('internet.username')",
                    field: "user.name",
                    sorter: "string",
                    headerFilter: 'input'
                },
                {
                    title: "@lang('internet.wifi_user')",
                    field: "wifi_username",
                    sorter: "string",
                    headerFilter: 'input'
                },
                {
                    title: "@lang('internet.mac_address')",
                    field: "mac_address",
                    sorter: "string",
                    headerFilter: 'input'
                },
            ],
        });
    });
</script>
