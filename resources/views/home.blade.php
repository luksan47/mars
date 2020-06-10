@extends('layouts.app')

@section('title')
<i class="material-icons left">chevron_right</i>@lang('general.home')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('general.you_are_logged_in')</span>
                @if (session('status'))
                <p>{{ session('status') }}</p>
                @endif
                <p>@lang('general.choose_from_menu')</p>
            </div>
        </div>
    </div>
</div>
@endsection