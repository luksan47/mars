@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <form method="POST" action="{{ route('password.email') }}">
            @csrf
                <div class="card-content">
                    <span class="card-title">@lang('passwords.resetpwd')</span>
                    @if (session('status'))
                    <blockquote class='error'>{{ session('status') }}</blockquote>
                    @endif
                    <div class="row">
                        <x-input.text id="email" locale="registration" type="email" autofocus required autocomplete="email"/>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <x-input.button only_input text="passwords.resetpwd" class="right"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
