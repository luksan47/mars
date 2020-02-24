@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        @include('print.print_status.print_status')
    </div>
</div>
<div class="row">
    <div class="col s12">
        @include("print.print.print")
    </div>
</div>
@if (Auth::user()->hasRole(\App\Role::PRINT_ADMIN))
<div class="row">
    <div class="col s12">
        <div class="card admin-card">
            <div class="card-content">
                <span class="card-title">Admin</span>
                @include("print.admin.free")
                @include("print.admin.modify")
            </div>
        </div>
    </div>
</div> 
@endif
@endsection
