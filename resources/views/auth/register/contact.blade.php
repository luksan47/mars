<div class="row">
    <div class="input-field col s12">
        <input type="text" id="country" name="country" value="Hungary" class="autocomplete validate">
        <label for="country">@lang('info.country')</label>
        @error('country')
        <blockquote class="error">{{ $message }}</blockquote>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="county" name="county" type="text" class="validate" value="{{ old('county') }}" required>
        <label for="county">@lang('info.county')</label>
        @error('county')
        <blockquote class="error">{{ $message }}</blockquote>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="zip_code" name="zip_code" type="number" class="validate" value="{{ old('zip_code') }}" required>
        <label for="zip_code">@lang('info.zip_code')</label>
        @error('zip_code')
        <blockquote class="error">{{ $message }}</blockquote>
        @enderror
    </div>
    <div class="input-field col s12">
        <input id="city" name="city" type="text" class="validate" value="{{ old('city') }}" required>
        <label for="city">@lang('info.city')</label>
        @error('city')
        <blockquote class="error">{{ $message }}</blockquote>
        @enderror
    </div>
    <div class="input-field col s12">
        <input id="street_and_number" name="street_and_number" type="text" class="validate"
            value="{{ old('street_and_number') }}" required>
        <label for="street_and_number">@lang('info.street_and_number')</label>
        @error('street_and_number')
        <blockquote class="error">{{ $message }}</blockquote>
        @enderror
    </div>
</div>