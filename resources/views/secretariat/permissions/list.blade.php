@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('secretariat.user.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.user_management')</a>
<a href="#!" class="breadcrumb">@lang('admin.permissions')</a>
@endsection
@section('secretariat_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.permissions')</span>
                <table>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td><a href="{{ route('secretariat.user.show', ['id' => $user->id]) }}" class="black-text" >{{ $user->name }}</a></td>
                            <td>@include('user.roles', ['roles' => $user->roles])</td>
                            <td>
                            @can('viewPermissionFor', $user)
                                <a href="{{ route('secretariat.permissions.show', $user->id) }}"
                                    class="btn-floating waves-effect waves-light right">
                                    <i class="material-icons">edit</i>
                                </a>
                            @endcan
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