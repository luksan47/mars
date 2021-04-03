@extends('layouts.app')
@section('title')
<i class="material-icons left">build</i>@lang('faults.faults')
@endsection
@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('faults.add-fault')</span>
                <blockquote>@lang('faults.fault_description')</blockquote>
                <form id="send-fault" class="form-horizontal" method="POST" action=" {{ route('faults.add') }} ">
                    @csrf
                    <x-input.text id="location" lang_file="faults" autofocus required/>
                    <x-input.textarea id="description" lang_file="faults" required/>
                    <x-input.button class="right" text="faults.submit"/>
                </form>
                @include('dormitory.faults.list')
            </div>
        </div>
    </div>
</div>
@endsection
