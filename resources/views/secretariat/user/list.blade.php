@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.user_management')</a>
@endsection
@section('secretariat_module') active @endsection

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
                                @lang('user.workshops')
                            </th>
                            <th colspan="3">
                                <a href="{{ route('secretariat.permissions.list') }}" class="btn waves-effect">
                                    @lang('role.roles')
                                    <i class="material-icons right">lock</i></a>
                                <a href="{{ route('secretariat.user.statuses') }}" class="btn waves-effect right">
                                    @lang('admin.statuses')
                                    <i class="material-icons right">school</i></a>
                            </th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        @can('view', $user)
                        <tr>
                            <td>
                                <b>{{ $user->name }}</b><br>
                                {{ $user->email }}
                                @if($user->hasEducationalInformation())
                                <br>{{ $user->educationalInformation->neptun ?? '' }}
                                @endif
                            </td>
                            <!-- Workshops -->
                            <td>
                                @if($user->hasEducationalInformation())
                                @can('viewEducationalInformation', $user)
                                    @include('user.workshop_tags', ['user' => $user, 'newline' => true])
                                @endcan
                                @endif
                            </td>
                            <!-- Roles -->
                            <td>
                                <!-- TODO policy -->
                                @include('user.roles', [
                                    'roles' => $user->roles->whereNotIn('name', ['internet-user', 'printer']),
                                    'newline' => true
                                ])
                            </td>
                            <!-- Status -->
                            <td>
                                @if($user->hasEducationalInformation())
                                @can('viewEducationalInformation', $user)
                                <span class="new badge {{ \App\Models\Semester::colorForStatus($user->getStatus()) }}" data-badge-caption="">
                                    @lang("user." . $user->getStatus())
                                </span>
                                @endcan
                                @endif
                            </td>
                            <!-- Edit -->
                            <td>
                                <div class="right">
                                    <a href="{{ route('secretariat.user.show', ['id' => $user->id]) }}" class="btn-floating waves-effect">
                                        <i class="material-icons">remove_red_eye</i></a>
                                </div>
                            </td>
                        </tr>
                        @endcan
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
