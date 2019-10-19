<div class="form-group row">
    <label for="year_of_graduation" class="col-md-4 col-form-label text-md-right">@lang('info.year_of_graduation')</label>

    <div class="col-md-6">
        <input id="year_of_graduation" type="number" class="form-control @error('year_of_graduation') is-invalid @enderror" name="year_of_graduation" value="{{ old('year_of_graduation') }}" required>

        @error('year_of_graduation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="high_school" class="col-md-4 col-form-label text-md-right">@lang('info.high_school')</label>

    <div class="col-md-6">
        <input id="high_school" type="text" class="form-control @error('high_school') is-invalid @enderror" name="high_school" value="{{ old('high_school') }}" required>

        @error('high_school')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="neptun" class="col-md-4 col-form-label text-md-right">@lang('info.neptun')</label>

    <div class="col-md-6">
        <input id="neptun" type="text" class="form-control @error('neptun') is-invalid @enderror" name="neptun" value="{{ old('neptun') }}" required>

        @error('neptun')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="year_of_acceptance" class="col-md-4 col-form-label text-md-right">@lang('info.year_of_acceptance')</label>

    <div class="col-md-6">
        <input id="year_of_acceptance" type="text" class="form-control @error('year_of_acceptance') is-invalid @enderror" name="year_of_acceptance" value="{{ old('year_of_acceptance') }}" required>

        @error('year_of_acceptance')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="faculty" class="col-md-4 col-form-label text-md-right">@lang('info.faculty')</label>

    <div class="col-md-6">
        @foreach($faculties as $faculty)
            <div class="checkbox">
                <label><input type="checkbox" name="faculty[]" value="{{ $faculty->id }}" {{ old('faculty') !== null && in_array($faculty->id, old('faculty')) ? 'checked' : '' }}> {{ $faculty->name }}</label>
            </div>
        @endforeach

        @error('faculty')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="workshop" class="col-md-4 col-form-label text-md-right">@lang('info.workshop')</label>

    <div class="col-md-8">
        @foreach($workshops as $workshop)
            <div class="checkbox">
                <label><input type="checkbox" name="workshop[]" value="{{ $workshop->id }}" {{ old('workshop') !== null && in_array($workshop->id, old('workshop')) ? 'checked' : '' }}> {{ $workshop->name }}</label>
            </div>
        @endforeach

        @error('workshop')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>