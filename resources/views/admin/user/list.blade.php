@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.user_management')</a>
@endsection
@section('admin_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.user_management')</span>
                <table>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <b>{{ $user->name }}</b><br>
                                {{ $user->email }}
                            </td>
                            {{-- Column for warnings --}}
                            <td>
                                @can('viewAny', \App\Models\WifiConnection::class)
                                    @if($user->wifiConnections->count() > \App\Models\WifiConnection::WARNING_THRESHOLD)
                                    <span class="new badge red" data-badge-caption="{{ $user->wifiConnections->count() }}">
                                        @lang('internet.wifi_connections') :
                                    </span>
                                    @endif
                                @endcan
                            </td>
                            <td>
                                @if($user->hasRoleBase(\App\Models\Role::COLLEGIST))
                                <span class="new badge {{ \App\Models\Semester::colorForStatus($user->getStatus()) }}" data-badge-caption="">
                                    @lang("user." . $user->getStatus())
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="right">
                                    @can('view', $user)
                                    <a href="{{ route('admin.user.semesters', ['id' => $user->id]) }}" class="btn-floating waves-effect">
                                        <i class="material-icons">school</i></a>
                                    @endcan
                                    @can('view', $user)
                                    <a href="{{ route('admin.user.show', ['id' => $user->id]) }}" class="btn-floating waves-effect">
                                        <i class="material-icons">remove_red_eye</i></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($users) == 0)
                        <tr>
                            <td>
                                @lang('internet.nothing_to_show')
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
