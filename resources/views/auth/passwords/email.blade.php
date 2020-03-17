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
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}"
                                required autocomplete="email" autofocus>
                            <label for="balance">@lang('registration.email')</label>
                            @error('email')
                            <blockquote class="error">{{ $message }}</blockquote>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="btn waves-effect right">@lang('passwords.resetpwd')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection