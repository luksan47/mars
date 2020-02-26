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
        <div class="card">
            <div class="card-content grey lighten-4">
                <div class="section">
                @include("print.admin.modify")
                </div>
                <div class="divider"></div>
                <div class="section">
                @include("print.admin.free")
                </div>
            </div>
        </div>
    </div>
</div> 
@endif
<div class="row">
    <div class="col s12">
        @include("print.history.history")
    </div>
</div>
@endsection
