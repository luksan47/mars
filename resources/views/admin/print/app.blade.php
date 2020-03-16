@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('print.print')</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                @include("admin.print.modify")
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                @include("admin.print.free")
            </div>
        </div>
    </div>
</div>

@endsection