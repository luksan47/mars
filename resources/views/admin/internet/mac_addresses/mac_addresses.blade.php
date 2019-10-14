<div class="card">
    <div class="card-header">@lang('internet.admin.manage_registered_devices')</div>
    <div class="card-body">
        @include('admin.internet.mac_addresses.add')
        <br/>
        <div class="alert alert-warning">
            <p>@lang('internet.edit_warning_auto_approve')</p>
        </div>
        @include('admin.internet.mac_addresses.list')
    </div>
</div>
