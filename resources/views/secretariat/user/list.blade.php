@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.user_management')</a>
@endsection
@section('secretariat_module') active @endsection

@section('content')

@livewire('list-users')

@endsection
