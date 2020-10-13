<div class="row">
    <div class="input-field col s12">
        <select searchable="@lang('general.search')" id="country" name="country">
            @foreach ($countries as $country)
            <option value="{{ $country }}" @if($country=="Hungary") selected @endif>{{ $country }} </option>
            @endforeach
          </select>
          <label for="country">@lang('user.country')</label>
          <script>
            var instances;
            $(document).ready(
              function() {
                var elems = $('#country');
                const options = [
                  @foreach ($countries as $country)
                  { name : '{{ $country }}',  value : '{{ $country }}' },
                  @endforeach
                  ]
                instances = M.FormSelect.init(elems, options);
          });
          </script>
          @error('country')
          <blockquote class="error">{{ $message }}</blockquote>
          @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="county" name="county" type="text" class="validate @error('county') invalid @enderror" value="{{ old('county') }}" required>
        <label for="county">@lang('user.county')</label>
        @error('county')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="zip_code" name="zip_code" type="number" class="validate @error('zip_code') invalid @enderror" value="{{ old('zip_code') }}" required>
        <label for="zip_code">@lang('user.zip_code')</label>
        @error('zip_code')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12">
        <input id="city" name="city" type="text" class="validate @error('city') invalid @enderror" value="{{ old('city') }}" required>
        <label for="city">@lang('user.city')</label>
        @error('city')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12">
        <input id="street_and_number" name="street_and_number" type="text" class="validate @error('street_and_number') invalid @enderror"
            value="{{ old('street_and_number') }}" required>
        <label for="street_and_number">@lang('user.street_and_number')</label>
        @error('street_and_number')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
</div>