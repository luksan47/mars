@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('print.print')</a>
@endsection
@section('admin_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                @include("admin.print.modify")
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                @include("admin.print.free")
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                @include("admin.print.account_history")
            </div>
        </div>
    </div>
    <div class="col s12">
        @include("print.print.free", ['route' => route('print.free_pages.list.all')])
    </div>
    <div class="col s12">
        @include("print.history.history", ['route' => route('print.print_jobs.list.all') ])
    </div>
</div>

@endsection