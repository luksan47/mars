
<div class="card">
    <div class="card-header @if(Auth::user()->hasRole(\App\Role::PRINT_ADMIN)) text-white bg-dark @endif">@lang('print.free')</div>
    <div class="card-body">
        <div class="alert alert-info">
            <strong>@lang('general.note'):</strong>
            @lang('print.free_pages_description')
        </div>
        <div id="free-page-table"></div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        var table = new Tabulator("#free-page-table", {
            paginationSizeSelector: [10, 25, 50, 100, 250, 500],
            paginationSize: 10,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('print.free_pages.all') }}", //set url for ajax request
            ajaxSorting: true,
            ajaxFiltering: true,
            layout: "fitColumns",
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
