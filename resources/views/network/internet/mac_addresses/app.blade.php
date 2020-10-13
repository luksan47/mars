<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('internet.your_registered_devices')</span>
        @include('network.internet.mac_addresses.info')
        @include('network.internet.mac_addresses.add')
        @include('network.internet.mac_addresses.list')
    </div>
</div>
