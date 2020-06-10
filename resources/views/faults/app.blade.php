@extends('layouts.app')
@section('title')
<i class="material-icons left">build</i>@lang('faults.faults')
@endsection
@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('faults.new_fault')</span>
                <blockquote>@lang('faults.fault_description')</blockquote>
                <form id="send-fault" class="form-horizontal" method="POST" action=" {{ route('faults.add') }} ">
                    @csrf
                    <div class="input-field col s12">
                        <input type="text" form="send-fault" id="location" name="location" autofocus required>
                        <label for="location">@lang('faults.location')</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea class="materialize-textarea" form="send-fault" name="description"
                            id="description"></textarea>
                        <label for="description">@lang('faults.description')</label>
                    </div>
                    <div class="col s12">
                        <p><button class="btn waves-effect right" type="submit">@lang('faults.submit')</button></p>
                    </div>
                </form>
                @include('faults.list')
            </div>
        </div>
    </div>
</div>
@endsection