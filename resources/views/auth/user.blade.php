@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('info.user_data')</div>
                <p>Your user data will appear here</p>
                <!--TODO-->
            </div>
            <div class="card-action">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="row">
                        <button class="btn waves-effect right " type="submit">@lang('general.logout')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection