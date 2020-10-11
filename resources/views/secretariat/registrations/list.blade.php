@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.registrations')</a>
@endsection
@section('secretariat_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.handle_registrations')</span>
                <table>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <b>{{ $user->name }}</b><br>
                                {{ $user->email }}
                                @if($user->hasEducationalInformation())
                                - {{ $user->educationalInformation->neptun ?? '' }}
                                @endif
                            </td>
                            <td>
                                <div class="right">
                                    <a href="{{ route('secretariat.registrations.show', ['id' => $user->id]) }}" class="btn-floating waves-effect">
                                        <i class="material-icons">search</i></a>
                                    <a href=" {{ route('secretariat.registrations.accept', ['id' => $user->id]) }}" class="btn-floating green waves-effect">
                                        <i class="material-icons">done</i></a>
                                    <a href="{{ route('secretariat.registrations.reject', ['id' => $user->id]) }}" class="btn-floating red waves-effect">
                                        <i class="material-icons">block</i></a>
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