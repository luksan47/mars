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
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" class="validate @error('email') invalid @enderror"
                                value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            <label for="email">@lang('registration.email')</label>
                            @error('email')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12">
                            <input id="password" name="password" type="password" class="validate @error('password') invalid @enderror" required
                                autocomplete="new-password">
                            <label for="password">@lang('registration.password')</label>
                            @error('password')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12">
                            <input id="password-confirm" name="password_confirmation" type="password" class="validate @error('password') invalid @enderror"
                                required autocomplete="new-password">
                            <label for="password-confirm">@lang('registration.confirmpwd')</label>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <button type="submit" class="btn waves-effect right">@lang('passwords.resetpwd')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection