<div id="mac-addresses-table"></div>
<script type="text/javascript" src="{{ mix('js/moment.min.js') }}"></script>
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
        var dateFormatter = function(cell, formatterParams){
            var value = cell.getValue();
            if(value){
                value = moment(value).format("YYYY. MM. DD. HH:mm");
            }
            return value;
        }

        var table = new Tabulator("#mac-addresses-table", {
            paginationSize: 10,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('internet.admin.mac_addresses.all') }}", //set url for ajax request
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
                {title: "@lang('internet.comment')", field: "comment", sorter: "string", headerFilter: 'input'},
                {
                    title: "@lang('internet.created_at')",
                    field: "created_at",
                    sorter: "datetime",
                    formatter: dateFormatter,
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
                {title: "", field: "state", width:"130", headerSort: false, formatter: actions},
                {title: "", field: "id", headerSort: false, formatter: deleteButton},
            ],
        });
    });
</script>
