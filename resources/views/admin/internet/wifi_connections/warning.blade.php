@can('viewAny', \App\Models\WifiConnection::class)
<span class="card-title">@lang('internet.users_over_threshold')</span>
<table>
    <tbody>
        @foreach ($users_over_threshold as $user)
        <tr>
            <td>
                <b>{{ $user->name }}</b>
            </td>
            <td>
                <span class="new badge red" data-badge-caption="
                    {{ $user->wifiConnections->count() }}
                    (@lang('internet.allowed') :
                    {{ $user->internetAccess->allowedConnectionCount() }}) " >
                        @lang('internet.wifi_connections') :
                </span>
            </td>
            @include('admin.internet.wifi_connections.show')
            <td>
                <div class="right">
                    @can('view', $user)
                    <a href="{{ route('admin.internet.wifi_connections.approve', ['user' => $user->id]) }}" class="btn-floating waves-effect">
                        <i class="material-icons">done</i></a>
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