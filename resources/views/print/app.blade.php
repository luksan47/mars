@extends('layouts.app')
@section('title')
<i class="material-icons left">local_printshop</i>@lang('print.print')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        @include("print.print.print")
    </div>
    <div class="col s12">
        @include("print.print.free", ['route' => route('print.free_pages.list')])
    </div>
    <div class="col s12">
        @include("print.send.send")
    </div>
    <div class="col s12">
        @include("print.history.history", ['route' => route('print.print_jobs.list')])
    </div>
</div>
@endsection
