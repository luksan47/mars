@can('viewAny', \App\Models\WifiConnection::class)
<span class="card-title">@lang('internet.users_over_threshold')</span>
<table>
    <thead>
        <tr>
            <th>
                @lang('internet.username')
            </th>
            <th>
                @lang('internet.approved_wifi_slots')
            </th>
            <th>
                @lang('internet.wifi_connections')
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users_over_threshold as $user)
        <tr>
            <td>
                <b>{{ $user->name }}</b>
            </td>
            <td>
                {{ $user->internetAccess->wifi_connection_limit }}
            </td>
            @include('network.wifi_connections.show')
            <td>
                <div class="right">
                    @can('view', $user)
                    <a href="{{ route('admin.internet.wifi_connections.approve', ['user' => $user->id]) }}" class="btn-floating waves-effect">
                        <i class="material-icons">exposure_plus_1</i></a>
                    @endcan
                </div>
            </td>
        </tr>
        @endforeach
        @if($users_over_threshold->count() == 0)
        <tr>
            <td>
                @lang('internet.nothing_to_show')
            </td>
        </tr>
        @endif
    </tbody>
</table>
<small>*@lang('user.wifi_connections_color_tooltip')</small>
@endcan