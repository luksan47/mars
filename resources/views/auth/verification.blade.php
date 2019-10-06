@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.successful_registration') }}</div>

                <div class="card-body">
                    {{ __('auth.wait_for_verification') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
