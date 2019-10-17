<div class="card">
    <div class="card-header">@lang('internet.your_registered_devices')</div>
    <div class="card-body">
        @include('internet.mac_addresses.info')
        <br/>
        @include('internet.mac_addresses.add')
        <br/>
        @include('internet.mac_addresses.list')
    </div>
</div>
