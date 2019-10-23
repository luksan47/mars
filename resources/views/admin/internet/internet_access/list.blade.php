<div id="mac-addresses-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
        var table = new Tabulator("#mac-addresses-table", {
            paginationSizeSelector: [10, 25, 50, 100, 250, 500],
            paginationSize: 10,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('internet.admin.internet_accesses.all') }}", //set url for ajax request
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
                    title: "@lang('internet.internet_access')",
                    field: "has_internet_until",
                    sorter: "datetime",
                    //editor: 'input',
                    headerFilter: 'input'
                },
                {
                    title: "@lang('internet.auto_approved_mac_slots')",
                    field: "auto_approved_mac_slots",
                    sorter: "number",
                    //editor: 'number',
                    headerFilter: 'number'
                }
            ],
        });
    });
</script>
