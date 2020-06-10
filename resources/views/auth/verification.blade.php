@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('auth.successful_registration')</div>
                <blockquote>@lang('auth.wait_for_verification')</blockquote>
            </div>
        </div>
    </div>
</div>
@endsection