<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">@lang('info.name')</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="place_of_birth" class="col-md-4 col-form-label text-md-right">@lang('info.place_of_birth')</label>

    <div class="col-md-6">
        <input id="place_of_birth" type="text" class="form-control @error('place_of_birth') is-invalid @enderror" name="place_of_birth" value="{{ old('place_of_birth') }}" required autocomplete="place-of-birth">

        @error('place_of_birth')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">@lang('info.date_of_birth')</label>

    <div class="col-md-6">
        <input id="date_of_birth" type="text" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required>

        @error('date_of_birth')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="mothers_name" class="col-md-4 col-form-label text-md-right">@lang('info.mothers_name')</label>

    <div class="col-md-6">
        <input id="mothers_name" type="text" class="form-control @error('mothers_name') is-invalid @enderror" name="mothers_name" value="{{ old('mothers_name') }}" required>

        @error('mothers_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="phone_number" class="col-md-4 col-form-label text-md-right">@lang('info.phone_number')</label>

    <div class="col-md-6">
        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="+36 (30) 123-4567" value="{{ old('phone_number') }}" required>

        @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>