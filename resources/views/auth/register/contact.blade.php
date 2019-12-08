<div class="form-group row">
    <label for="country" class="col-md-4 col-form-label text-md-right">@lang('info.country')</label>

    <div class="col-md-6">
        <select id="country" class="form-control @error('country') is-invalid @enderror bfh-countries"  name="country" data-country="HU" data-blank="false"></select>

        @error('country')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="county" class="col-md-4 col-form-label text-md-right">@lang('info.county')</label>

    <div class="col-md-6">
        <input id="county" type="text" class="form-control @error('county') is-invalid @enderror" name="county" value="{{ old('county') }}" required>

        @error('county')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="zip_code" class="col-md-4 col-form-label text-md-right">@lang('info.zip_code')</label>

    <div class="col-md-6">
        <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ old('zip_code') }}" required>

        @error('zip_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="city" class="col-md-4 col-form-label text-md-right">@lang('info.city')</label>

    <div class="col-md-6">
        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required>

        @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="street_and_number" class="col-md-4 col-form-label text-md-right">@lang('info.street_and_number')</label>

    <div class="col-md-6">
        <input id="street_and_number" type="text" class="form-control @error('street_and_number') is-invalid @enderror" name="street_and_number" value="{{ old('street_and_number') }}" required>

        @error('street_and_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>