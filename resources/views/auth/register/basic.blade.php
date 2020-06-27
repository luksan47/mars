<div class="row">
    <div class="input-field col s12">
        <input type="email" id="email" name="email" class="validate @error('email') invalid @enderror"
            value="{{ old('email') }}" autocomplete="email" autofocus required>
        <label for="email">@lang('registration.email')</label>
        @error('email')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="password" type="password" class="validate @error('password') invalid @enderror" name="password" required autocomplete="new-password">
        <label for="password">@lang('registration.password')</label>
        @error('password')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="password-confirm" type="password" class="validate @error('password') invalid @enderror" name="password_confirmation" required
            autocomplete="new-password">
        <label for="password-confirm">@lang('registration.confirmpwd')</label>
    </div>
</div>