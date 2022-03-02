@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('routers') }}" class="breadcrumb">@lang('router.router_monitor')</a>
<a href="#!" class="breadcrumb">{{ $router->ip }}</a>
@endsection
@section('admin_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('router.router')
                    @can('update', $router)
                        <x-input.button :href="route('routers.edit', $router->ip)" floating class="right" icon="edit" />
                    @endcan
                    @can('delete', $router)
                        <form action="{{ route('routers.delete', $router->ip) }}" method="POST" class="right" style="margin-right:10px">
                            @csrf
                            <x-input.button floating icon="delete" class="red" />
                        </form>
                    @endcan
                </span>
                <table>
                    <tbody>
                        <tr>
                            <th scope="row">@lang('router.ip')</th>
                            <td>{{ $router->ip }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('router.room')</th>
                            <td>{{ $router->room }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('router.port')</th>
                            <td>{{ $router->port }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('router.type')</th>
                            <td>{{ $router->type }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('router.serial_number')</th>
                            <td>{{ $router->serial_number }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('internet.mac_address')</th>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>WAN:</th>
                                            <td>{{ $router->mac_WAN }}</td>
                                        </tr>
                                        <tr>
                                            <th>2G/LAN:</th>
                                            <td>{{ $router->mac_2G_LAN }}</td>
                                        </tr>
                                        <tr>
                                            <th>5G:</th>
                                            <td>{{ $router->mac_5G }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('internet.comment')</th>
                            <td>{{ $router->comment }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('router.date_of_acquisition')</th>
                            <td>{{ $router->date_of_acquisition }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('router.date_of_deployment')</th>
                            <td>{{ $router->date_of_deployment }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

