@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    @lang('faults.new_fault')
                </div>
                <div class="card-body">
                    <form id="send-fault" class="form-horizontal" method="POST" action=" {{ route('faults.add') }} ">
                        @csrf
                        <input class="form-control" form="send-fault" name="location" placeholder="@lang('faults.location')"><br>
                        <textarea class="form-control" form="send-fault" name="description" style="height: 8em" placeholder="@lang('faults.description')"></textarea>

                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                            <div class="col-md-5"></div>
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn btn-primary" value="@lang('faults.submit')" />
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </form>
                </div>
            </div>
            @include('faults.list')
        </div>
    </div>
</div>
@endsection
