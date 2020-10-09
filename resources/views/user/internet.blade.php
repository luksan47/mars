{{-- Internet --}}
@if($user->hasRole(\App\Models\Role::INTERNET_USER))
@can('view', $user->internetAccess)
<div class="card">
    <div class="card-content">
        <div class="card-title">@lang('internet.internet')</div>
        <table>
            <tbody>
                <tr>
                    <th scope="row">@lang('internet.internet_access')</th>
                    <td>
                        <span class="new badge @if($user->internetAccess->isActive()) green @else red @endif" data-badge-caption="">
                            @if($user->internetAccess->has_internet_until != null)
                                {{ $user->internetAccess->has_internet_until }}
                            @else
                                @lang('internet.disabled')
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">@lang('internet.wifi_user')</th>
                    <td>{{ $user->internetAccess->wifi_username }}</td>
                </tr>
                <tr>
                    <th scope="row">@lang('internet.wifi_password')</th>
                    <td>{{ $user->internetAccess->wifi_password }}</td>
                </tr>
                @can('viewAny', \App\Models\WifiConnection::class)
                <tr>
                    <th scope="row">@lang('internet.wifi_connections')</th>
                    @include('admin.internet.wifi_connections.show', ['showTooltip' => true])
                </tr>
                @endcan
                <tr>
                    <th scope="row">@lang('internet.mac_address')</th>
                    <td>
                        <ul>
                            @foreach ($user->macAddresses as $mac)
                                @can('view', $mac)
                                <li>
                                <span class="new badge
                                    @if($mac->state == \App\Models\MacAddress::APPROVED)
                                        green
                                    @elseif($mac->state == \App\Models\MacAddress::REQUESTED)
                                        orange
                                    @else
                                        red
                                    @endif" data-badge-caption="">
                                    {{ $mac->mac_address }}
                                    </span>
                                    <small><i>{{ $mac->comment }} </i></small>
                                </li>
                                @endcan
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endcan
@endif
