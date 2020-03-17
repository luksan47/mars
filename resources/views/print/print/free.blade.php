<!--TODO: visible only if user have free pages-->

<p>@lang('print.free'):</p>
<div id="free-page-table"></div>
<blockquote>@lang('print.free_pages_description')</blockquote>
<script type="application/javascript">
    $(document).ready(function () {
        var table = new Tabulator("#free-page-table", {
            paginationSize: 10,
            layout: "fitColumns",
            pagination: "remote", //enable remote pagination
            ajaxSorting: true,
            ajaxFiltering: true,
            columnMinWidth: 150,
            headerSort: false,
            ajaxURL: "{{ route('print.free_pages.all') }}", //set url for ajax request
            placeholder: "@lang('print.no_free_pages')",
            columns: [
                @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN))
                {
                    title: "@lang('internet.created_at')",
                    field: "created_at",
                    sorter: "datetime",
                    headerFilter: 'input'
                },
                {
                    title: "@lang('print.user')",
                    field: "user.name",
                    sorter: "string",
                    headerFilter: 'input'
                },
                @endif
                {
                    title: "@lang('print.free')",
                    field: "amount",
                    sorter: "number",
                    @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) headerFilter: 'input' @endif
                },
                {
                    title: "@lang('print.deadline')",
                    field: "deadline",
                    sorter: "datetime",
                    @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) headerFilter: 'input' @endif
                },
                {
                    title: "@lang('print.last_modified_by')",
                    field: "modifier",
                    sorter: "string",
                    @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) headerFilter: 'input' @endif
                },
                {
                    title: "@lang('internet.comment')",
                    field: "comment",
                    sorter: "string",
                    @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) headerFilter: 'input' @endif
                },
            ],
        });
    });
</script>