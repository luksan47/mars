<span class="card-title">@lang('internet.wifi_connections')</span>
<div id="wifi-connections-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
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
                //TODO: add block button
            ],
        });
    });
</script>
