@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('admin.registrations') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.registrations')</a>
<a href="#!" class="breadcrumb">{{ $user->name }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12">

        <div class="card">
            <div class="card-content">
                <h5><b>{{ $user->name }}</b> ({{ $users_left}} @lang('document.left'))
                <div class="right">
                    <a href="{{ route('admin.registrations.reject', ['id' => $user->id, 'next' => true]) }}" class="btn-floating red waves-effect">
                        <i class="material-icons">block</i></a>
                    <a href="{{ route('admin.registrations.accept', ['id' => $user->id, 'next' => true]) }}" class="btn-floating green waves-effect">
                        <i class="material-icons">done</i></a>
                </div></h5>
            </div>
        </div>
        {{-- Personal information --}}
        @include('user.personal-information', ['user' => $user])
        {{-- Educational information --}}
        @include('user.educational-information', ['user' => $user])
    </div>
</div>
@endsection