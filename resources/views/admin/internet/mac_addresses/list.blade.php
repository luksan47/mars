<div class="card">
    <div class="card-header">@lang('internet.admin.manage_register_devices')</div>
    <div class="card-body">
        <form action="{{ route('internet.mac_addresses.add') }}" method="post">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-row align-items-center">
                @csrf
                <div class="col-auto">
                    <label for="inlineFormInput">@lang('internet.user_id')</label> {{-- TODO: Better user selection --}}
                    <input type="text" class="form-control mb-2" name="user_id" placeholder="1">
                </div>
                <div class="col-auto">
                    <label for="inlineFormInput">@lang('internet.mac_address')</label>
                    <input type="text" class="form-control mb-2" name="mac_address" placeholder="00:00:00:00:00:00">
                </div>
                <div class="col-auto">
                    <label for="inlineFormInput">@lang('internet.comment')</label>
                    <input type="text" class="form-control mb-2" name="comment" placeholder="Laptop">
                </div>
                <div class="col-auto">
                    <label>&nbsp;</label>
                    <button type="submit" class="form-control btn btn-primary mb-2">@lang('internet.add')</button>
                </div>
            </div>
        </form>

        <br/>

        <div id="mac-addresses-table"></div>
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

                    return $("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-danger float-left\">@lang('internet.reject')</button>").click(function () {
                        changeState('rejected');
                    }).toggle(data._state === '{{ \App\MacAddress::REQUESTED }}').add($("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-success float-left\">@lang('internet.approve')</button>").click(function () {
                        changeState('approved');
                    }).toggle(data._state === '{{ \App\MacAddress::REQUESTED }}')).add($("<button type=\"button\" style=\"margin: 2px;\" class=\"btn btn-sm btn-warning float-left\">@lang('internet.request')</button>").click(function () {
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

                var table = new Tabulator("#mac-addresses-table", {
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
    </div>
</div>
