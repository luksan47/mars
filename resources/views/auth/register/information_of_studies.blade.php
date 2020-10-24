<div class="row">
    <div class="input-field col s12">
        <input id="high_school" name="high_school" type="text" class="validate @error('high_school') invalid @enderror" value="{{ old('high_school') }}" required>
        <label for="high_school">@lang('user.high_school')</label>
        @error('high_school')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>

    <div class="input-field col s6">
        <input id="year_of_graduation" name="year_of_graduation" min="1895" max="{{ date('Y') }}" type="number"
            class="validate @error('year_of_graduation') invalid @enderror" value="{{ old('year_of_graduation') }}" required>
        <label for="year_of_graduation">@lang('user.year_of_graduation')</label>
        @error('year_of_graduation')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>

    <div class="input-field col s6">
        <input id="year_of_acceptance" name="year_of_acceptance" type="number" min="1895" max="{{ date('Y') }}"
            class="validate @error('year_of_acceptance') invalid @enderror" value="{{ old('year_of_acceptance') }}" required>
        <label for="year_of_acceptance">@lang('user.year_of_acceptance')</label>
        @error('year_of_acceptance')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>

    <div class="input-field col s6">
        <input id="neptun" name="neptun" type="text" class="validate @error('neptun') invalid @enderror" value="{{ old('neptun') }}" required>
        <label for="neptun">@lang('user.neptun')</label>
        @error('neptun')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>

    <div class="input-field col s6">
        @include('utils.select', ['elements' => \App\Models\Role::possibleObjectsFor(\App\Models\Role::COLLEGIST), 'element_id' => 'collegist_status', 'label' => __('user.status')])
    </div>

    <div class="input-field col s12">
        <input type="email" id="educational_email" name="educational_email" class="validate @error('educational_email') invalid @enderror"
            value="{{ old('educational_email') }}" autocomplete="educational_email" autofocus required>
        <label for="educational_email">@lang('user.educational-email')</label>
        @error('educational_email')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>

    <div class="input-field col s12">
        <p><label>@lang('user.faculty')</label></p>
        @foreach($faculties as $faculty)
        <p><label>
            <input type="checkbox" name="faculty[]" value="{{ $faculty->id }}" @if(old('faculty') !== null && in_array($faculty->id, old('faculty'))) checked @endif >
            <span>{{ $faculty->name }}</span>
        </label></p>
        @endforeach
        @error('faculty')
        <blockquote class="error">@lang('user.faculty_must_be_filled')</blockquote>
        @enderror
    </div>

    <div class="input-field col s12">
        <p><label>@lang('user.workshop')</label></p>
        @foreach($workshops as $workshop)
        <p><label>
            <input type="checkbox" name="workshop[]" value="{{ $workshop->id }}" @if(old('workshop') !== null && in_array($workshop->id, old('workshop'))) checked @endif >
            <span>{{ $workshop->name }}</span>
        </label></p>
        @endforeach
        @error('workshop')
        <blockquote class="error">@lang('user.workshop_must_be_filled')</blockquote>
        @enderror
    </div>
</div>