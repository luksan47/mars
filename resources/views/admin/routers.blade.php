@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('router.router_monitor')</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.handle_registrations')</span>
                <table>
                    <thead>
                        <tr>
                            <th>@lang('router.ip')</th>
                            <th>@lang('router.room')</th>
                            <th>@lang('router.state')</th>
                            <th>@lang('router.failing_since')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routers as $router)
                        <tr>
                            <td>
                                {{ $router->ip }}
                            </td>
                            <td>
                                {{ $router->room }}
                            </td>
                            <td>
                                @if($router->isUp())
                                    <span class="new badge green" data-badge-caption="">@lang('router.up')</span>
                                @else
                                    <span class="new badge red" data-badge-caption="{{ $router->failed_for }}"> @lang('router.down'): </span>
                                @endif
                            </td>
                            <td>
                                @if($router->isDown())
                                {{ $router->getFailStartDate() }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection