@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col s12 l8 offset-l2">
      <div class="card">
        <div class="card-image">
          <img src="img/EC_building.jpg">
          <span class="card-title">@lang('general.login')</span>
        </div>
        <form method="POST" action="{{ route('login') }}">
        @csrf    
            <div class="card-content">
                @error('email')
                <blockquote>{{ $message }}</blockquote>
                @enderror
                @error('password')
                <span>{{ $message }}</span>
                @enderror
                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" id="email" name="email" class="validate" value="{{ old('email') }}" autocomplete="email" autofocus required>
                        <label for="autocomplete-input">@lang('registration.email')</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate" name="password" required autocomplete="current-password">
                        <label for="password">@lang('registration.password')</label>
                        @if (Route::has('password.request'))
                            <span class="helper-text">
                                <a href="{{ route('password.request') }}">
                                @lang('registration.forgotpwd')
                                </a>
                            </span>
                        @endif
                    </div>   
                </div>
            </div>
            <div class="card-action">
                <label class="right">
                    <input type="checkbox" name="remember" id="remember" class="filled-in checkbox-color" {{ old('remember') ? 'checked' : '' }} />
                    <span>@lang('registration.remember')</span>
                </label>
                <button class="btn waves-effect" type="submit" >@lang('general.login')</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
