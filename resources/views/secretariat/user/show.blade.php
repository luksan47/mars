@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('secretariat.user.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.user_management')</a>
<a href="#!" class="breadcrumb">{{ $user->name }}</a>
@endsection
@section('secretariat_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">{{ $user->name }} <small>({{ $user->email }})</small></div>
                @include('user.roles_status_table', ['user' => $user])
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