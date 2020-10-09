@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('admin.user.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.user_management')</a>
<a href="#!" class="breadcrumb">{{ $user->name }}</a>
@endsection
@section('admin_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">

        <div class="card">
            <div class="card-content">
                <div class="card-title">{{ $user->name }} <small>({{ $user->email }})</small></div>
                    <table>
                        <tbody>
                            <tr>
                                <th>@lang('role.roles')</th>
                                <td>@include('user.roles', ['roles' => $user->roles])</td>
                                <td>
                                @can('viewPermissionFor', $user)
                                    <a href="{{ route('admin.permissions.show', $user->id) }}"
                                        class="btn-floating waves-effect waves-light right">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endcan
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('user.status')</th>
                                <td>
                                    <span class="new badge {{ \App\Semester::colorForStatus($user->getStatus()) }}" data-badge-caption="">
                                        @lang("user." . $user->getStatus())
                                    </span></td>
                                <td>
                                <!-- TODO policy for semesters, and create a blade for this table -->
                                <a href="{{ route('admin.user.semesters', ['id' => $user->id]) }}" class="btn-floating waves-effect right">
                                        <i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>

        {{-- Internet --}}
        @include('user.internet', ['user' => $user])
        {{-- Printing --}}
        @include('user.printing', ['user' => $user])
        {{-- Personal information --}}
        @include('user.personal-information', ['user' => $user])
        {{-- Educational information --}}
        @include('user.educational-information', ['user' => $user])
    </div>
</div>
@endsection