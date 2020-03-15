<div class="input-field col s12">
    <input id="year_of_graduation" name="year_of_graduation" min="1895" max="{{ date('Y') }}" type="number"
        class="validate" value="{{ old('year_of_graduation') }}" required>
    <label for="year_of_graduation">@lang('info.year_of_graduation')</label>
    @error('year_of_graduation')
    <blockquote class="error">{{ $message }}</blockquote>
    @enderror
</div>

<div class="input-field col s12">
    <input id="high_school" name="high_school" type="text" class="validate" value="{{ old('high_school') }}" required>
    <label for="year_of_graduation">@lang('info.high_school')</label>
    @error('high_school')
    <blockquote class="error">{{ $message }}</blockquote>
    @enderror
</div>

<div class="input-field col s12">
    <input id="neptun" name="neptun" type="text" class="validate" value="{{ old('neptun') }}" required>
    <label for="neptun">@lang('info.neptun')</label>
    @error('neptun')
    <blockquote class="error">{{ $message }}</blockquote>
    @enderror
</div>

<div class="input-field col s12">
    <input id="year_of_acceptance" name="year_of_acceptance" type="number" min="1895" max="{{ date('Y') }}"
        class="validate" value="{{ old('year_of_acceptance') }}" required>
    <label for="year_of_acceptance">@lang('info.year_of_acceptance')</label>
    @error('year_of_acceptance')
    <blockquote class="error">{{ $message }}</blockquote>
    @enderror
</div>

<div class="input-field col s12">
    <p>@lang('info.faculty')</p>
    @foreach($faculties as $faculty)
    <p><label>
        <input type="checkbox" name="faculty[]" value="{{ $faculty->id }}" @if(old('faculty') !== null && in_array($faculty->id, old('faculty'))) checked @endif >
        <span>{{ $faculty->name }}</span>
    </label></p>
    @endforeach
    @error('faculty')
    <blockquote class="error">@lang(info.faculty_must_be_filled)</blockquote>
    @enderror
</div>

<div class="input-field col s12">
    <p>@lang('info.workshop')</p>
    @foreach($workshops as $workshop)
    <p><label>
        <input type="checkbox" name="workshop[]" value="{{ $workshop->id }}" @if(old('workshop') !== null && in_array($workshop->id, old('workshop'))) checked @endif >
        <span>{{ $workshop->name }}</span>
    </label></p>
    @endforeach
    @error('workshop')
    <blockquote class="error">@lang(info.workshop_must_be_filled)</blockquote>
    @enderror
</div>