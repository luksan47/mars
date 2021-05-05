@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('secretariat.user.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.user_management')</a>
<a href="{{ route('secretariat.permissions.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.permissions')</a>
<a href="#!" class="breadcrumb">{{ $user->name }}</a>
@endsection
@section('secretariat_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
    {{-- Roles of user --}}
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $user->name }}@lang('admin.users_roles')</span>
                <table>
                    <tbody>
                        @foreach ($user->roles->sortBy('name') as $role)
                        <tr>
                            <td>{{ $role->name() }}</td>
                            <td>
                                @if($role->canHaveObject())
                                    {{ __('role.'.$role->object()->name) ?? ''}}
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('secretariat.permissions.remove', ['id' => $user->id, 'role_id' => $role->id, 'object_id' => $role->pivot->object_id]) }}" method="post">
                                @csrf
                                <x-input.button floating class="right red" icon="delete" />
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
                <div class="row">
                @foreach (App\Models\Role::all()->sortBy('name') as $role)
                    @if(!$user->roles->contains($role) || $role->canHaveObject())
                        <form action="{{ route('secretariat.permissions.edit', ['id' => $user->id, 'role_id' => $role->id]) }}" method="post">
                            @csrf
                            @if($role->canHaveObject())
                                @php $elements = $role->possibleObjects()->map(function ($object) {
                                    return (object)['id' => $object->id, 'name' => __('role.'.$object->name)];});
                                @endphp
                                <x-input.select s=11 without_label :elements="$elements" :id="$role->name" :placeholder="__('role.'.$role->name)"/>
                            @else
                                <x-input.text s=11 without_label id="blank" :value="__('role.'.$role->name)" disabled/>
                            @endif
                            <div class="input-field col s1"><x-input.button floating class="right green" icon="add" /></div>
                        </form>
                    @endif
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
