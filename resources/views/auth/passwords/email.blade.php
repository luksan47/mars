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
                            <input id="email" name="email" type="email" class="validate @error('email') invalid @enderror" value="{{ old('email') }}"
                                required autocomplete="email" autofocus>
                            <label for="email">@lang('registration.email')</label>
                            @error('email')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
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