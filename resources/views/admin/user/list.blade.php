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
                    <thead>
                        <tr>
                            <th>@lang('print.user')</th>
                            <th>
                                <a href="{{ route('admin.permissions.list') }}" class="btn waves-effect">
                                    @lang('role.roles')
                                    <i class="material-icons right">lock</i></a>
                            </th>
                            <th colspan="2">
                                <a href="{{ route('admin.user.statuses') }}" class="btn waves-effect">
                                    @lang('admin.statuses')
                                    <i class="material-icons right">school</i></a>
                            </th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <b>{{ $user->name }}</b><br>
                                {{ $user->email }}
                                @if($user->hasEducationalInformation())
                                <br>{{ $user->educationalInformation->neptun ?? '' }}
                                @endif
                            </td>
                            <!-- Roles -->
                            <td>
                                @include('user.roles', [
                                    'roles' => $user->roles->whereNotIn('name', [App\Role::COLLEGIST, App\Role::INTERNET_USER]),
                                    'newline' => true
                                ])
                            </td>
                            <!-- Status -->
                            <td>
                                @if($user->hasRoleBase(\App\Models\Role::COLLEGIST))
                                <span class="new badge {{ \App\Models\Semester::colorForStatus($user->getStatus()) }}" data-badge-caption="">
                                    @lang("user." . $user->getStatus())
                                </span>
                                @endif
                            </td>
                            <!-- Edit -->
                            <td>
                                <div class="right">
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
