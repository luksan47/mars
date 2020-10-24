<span class="card-title">@lang('print.history')</span>
<div id="account-history-table"></div>
<script type="application/javascript">
$(document).ready(function() {
    var table = new Tabulator("#account-history-table", {
        paginationSize: 20,
        layout: "fitColumns",
        pagination: "remote", //enable remote pagination
        ajaxURL: "{{ route('print.account_history') }}", //set url for ajax request
        ajaxSorting: true,
        ajaxFiltering: true,
        placeholder: "@lang('internet.nothing_to_show')",
        headerSort: false,
        columns: [
            {
                title: "@lang('print.user')",
                field: "user.name",
                sorter: "string",
                headerFilter: 'input',
                minWidth:200
            },
            {
                title: "@lang('print.balance_change')",
                field: "balance_change",
                sorter: "number",
                minWidth:100
            },
            {
                title: "@lang('print.free_page_change')",
                field: "free_page_change",
                sorter: "number",
                minWidth:100
            },
            {
                title: "@lang('print.deadline_change')",
                field: "deadline_change",
                sorter: "date",
                minWidth:180
            },
            {
                title: "@lang('print.modified_by')",
                field: "modifier.name",
                sorter: "string",
                headerFilter: 'input',
                minWidth:180
            },
            {
                title: "@lang('print.modified_at')",
                field: "modified_at",
                sorter: "date",
                minWidth:180
            },
        ],
        initialSort: [
            {column: "modified_at", dir: "desc"}
        ]
    });
});
</script>
