<div class="row">
    <div class="input-field col s12">
        <input type="email" id="email" name="email" class="validate" value="{{ old('email') }}" autocomplete="email"
            autofocus required>
        <label for="email">@lang('registration.email')</label>
        @error('email')
        <blockquote class="error">{{ $message }}</blockquote>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="password" type="password" class="validate" name="password" required autocomplete="new-password">
        <label for="password">@lang('registration.password')</label>
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="password-confirm" type="password" class="validate" name="password_confirmation" required
            autocomplete="new-password">
        <label for="password-confirm">@lang('registration.confirmpwd')</label>
    </div>
    @error('password')
    <blockquote class="error">{{ $message }}</blockquote>
    @enderror
</div>