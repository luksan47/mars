<div id="mac-addresses-table"></div>
<script type="application/javascript">
    $(document).ready(function () {
        var activation_date = new Date("{{ $activation_date }}");
        var now = new Date();
        var actions = function (cell, formatterParams, onRendered) {
            var data = cell.getRow().getData();
            var active = (new Date(data.has_internet_until));
            return $("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-success float-left\" title=\"{{ $activation_date }}\">@lang('internet.extend')</button>")
                .click(function () {
                    saveData(cell, {...data, has_internet_until: "{{ $activation_date }}"});
                }).toggle(data.has_internet_until == null || activation_date > active)
                .add($("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-danger float-left\">@lang('internet.deactivate')</button>")
                    .click(function () {
                        saveData(cell, {...data, has_internet_until: null});
                    }).toggle(data.has_internet_until != null && active > now)).wrapAll('<div></div>').parent()[0];
        };

        var saveData = function(cell, data = null) {
            $(cell.getRow().getElement()).addClass('tabulator-unsaved');
            if(data == null) data = cell.getRow().getData();
            $.ajax({
                type: "POST",
                url: "{{ route('internet.internet_accesses.edit', [':id']) }}".replace(':id', data.user_id),
                data,
                success: function (response) {
                    response = {...data, ...response, id: response.user_id};
                    cell.getTable().updateData([response]);
                    cell.getRow().reformat();
                    $(cell.getRow().getElement()).removeClass('tabulator-unsaved');
                },
                error: function (error) {
                    ajaxError('@lang('internet.error')', '@lang('internet.ajax_error')', '@lang('internet.ok')', error);
                }
            });
        };

        var editCallback = function (cell) {
            saveData(cell);
        };

        var table = new Tabulator("#mac-addresses-table", {
            paginationSizeSelector: [10, 25, 50, 100, 250, 500],
            paginationSize: 10,
            pagination: "remote", //enable remote pagination
            ajaxURL: "{{ route('internet.admin.internet_accesses.all') }}", //set url for ajax request
            ajaxSorting: true,
            ajaxFiltering: true,
            layout: "fitColumns",
            placeholder: "No Data Set",
            cellEditing:function(cell) {
                $(cell.getRow().getElement()).addClass('tabulator-unsaved');
            },
            cellEditCancelled:function(cell) {
                $(cell.getRow().getElement()).removeClass('tabulator-unsaved');
            },
            cellEdited: editCallback,
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
                    title: "@lang('internet.internet_access')",
                    field: "has_internet_until",
                    sorter: "datetime",
                    editor: 'input'
                },
                {
                    title: "@lang('internet.auto_approved_mac_slots')",
                    field: "auto_approved_mac_slots",
                    sorter: "number",
                    editor: 'number',
                },
                {title: "", field: "state", headerSort: false, formatter: actions},
            ],
            ajaxResponse: function (url, params, response) {
                response.data = response.data.map(record => {
                    return {...record, id: record.user_id}
                });
                return response;
            },
        });
    });
</script>
