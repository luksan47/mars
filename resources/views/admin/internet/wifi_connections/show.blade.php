<td>
    <ul>
        @foreach ($user->wifiConnections as $wifiConnection)
            @can('view', $wifiConnection)
            <li>
                <span class="new badge {{ $wifiConnection->getColor() }}" data-badge-caption="">
                    {{ $wifiConnection->ip }} : {{ $wifiConnection->mac_address }}
                </span>
            </li>
            @endcan
        @endforeach
    </ul>
    @if($showTooltip ?? false)
    <small>*@lang('user.wifi_connections_color_tooltip')</small>
    @endif
</td>