@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.user_management')</a>
@endsection
@section('secretariat_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.user_management')</span>
                @livewire('list-users')
            </div>
        </div>
    </div>
</div>
@endsection
