@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="card-content">
                    <div class="card-title"> @lang('passwords.resetpwd')</div>
                    <div class="row">
                        <x-input.text id="email"    lang_file="registration" type="email" :value="$email" required autocomplete="email" autofocus/>
                        <x-input.text id="password" lang_file="registration" type="password" required autocomplete="new-password"/>
                        <x-input.text id="confirmpwd" lang_file="registration" name="password_confirmation" type="password" required autocomplete="new-password"/>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <x-input.button text="passwords.resetpwd" class="right"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
