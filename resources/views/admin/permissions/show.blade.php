@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.permissions')</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
    {{-- Roles of user --}}
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $user->name }} - @lang('admin.permissions') </span>
                <table>
                    <tbody>
                        @foreach ($user->roles->sortBy('name') as $role)
                        <tr>
                            <td>{{ $role->name() }}</td>
                            <td>
                                @if($role->pivot->object_id)
                                    : {{ $role->pivot->object->name }}
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.permissions.remove', $user->id) }}" method="post">
                                @csrf
                                <input type="number" name="role" value="{{ $role->id }}" hidden>
                                <button type="submit" class="btn-floating waves-effect waves-light right red">
                                    <i class="material-icons">delete</i>
                                </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Rest of the roles --}}
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.other_permissions') </span>
                <table>
                    <tbody>
                        @foreach (App\Role::all()->except($user->roles->modelKeys())->sortBy('name') as $role)
                        <form action="{{ route('admin.permissions.edit', $user->id) }}" method="post">
                        @csrf
                            <tr>
                                <td>{{ $role->name() }}</td>
                                <td>
                                    @if($role->canHaveObject())
                                        @include("utils/select", ['elements' => $role->possibleObjects(), 'element_id' => $role->name, 'label' => ''])
                                    @endif
                                    <input type="number" name="role" value="{{ $role->id }}" hidden>
                                </td>
                                <td>
                                    <button type="submit" class="btn-floating waves-effect waves-light right green">
                                        <i class="material-icons">add</i>
                                    </button>
                                </td>
                            </tr>
                        </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection