@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.permissions')</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $user->name }} - @lang('admin.permissions') </span>
                <table>
                    <tbody>
                        <!-- TODO:Show all -->
                        @foreach ($user->roles as $role)
                        <tr>
                            <td>{{ $role->name() }}</td>
                            <td>
                                @if($role->pivot->object_id)
                                    : {{ $role->pivot->object->name }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.permissions.edit') }}" class="btn-floating waves-effect waves-light right red">
                                    <i class="material-icons">delete</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.other_permissions') </span>
                <table>
                    <tbody>
                        <!-- TODO:Show all -->
                        @foreach (App\Role::all()->except($user->roles->modelKeys()) as $role)
                        @if(!$role->canHaveObject())
                        <tr>
                            <td>{{ $role->name() }}</td>
                            <td>
                            </td>
                            <td>
                                <a href="{{ route('admin.permissions.edit') }}" class="btn-floating waves-effect waves-light right green">
                                    <i class="material-icons">add</i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        @foreach (App\Role::all() as $role)
                        @if($role->canHaveObject())
                        <tr>
                            <td>{{ $role->name() }}</td>
                            <td>
                                @include("utils/select", ['elements' => $role->possibleObjects(), 'element_id' => $role->name])
                            </td>
                            <td>
                                <a href="{{ route('admin.permissions.edit') }}" class="btn-floating waves-effect waves-light right green">
                                    <i class="material-icons">add</i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection