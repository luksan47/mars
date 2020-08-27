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
                <span class="card-title">{{ $user->name }} </span>
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
    </div>
</div>
@endsection