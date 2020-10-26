<div class="row">
    <div class="input-field col s12">
        <input id="name" name="name" type="text" class="validate @error('name') invalid @enderror" value="{{ old('name') }}" required autocomplete="name">
        <label for="name">@lang('user.name')</label>
        @error('name')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input id="place_of_birth" name="place_of_birth" type="text" class="validate @error('place_of_birth') invalid @enderror" value="{{ old('place_of_birth') }}"
            required autocomplete="place_of_birth">
        <label for="place_of_birth">@lang('user.place_of_birth')</label>
        @error('place_of_birth')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12 m12 l6">
        <input type="text" class="datepicker validate @error('date_of_birth') invalid @enderror" id="date_of_birth" name="date_of_birth"
            value="{{ old('date_of_birth') }}" required onfocus="M.Datepicker.getInstance(date_of_birth).open();">
        <label for="date_of_birth">@lang('user.date_of_birth')</label>
        @error('date_of_birth')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12">
        <input id="mothers_name" name="mothers_name" type="text" class="validate @error('mothers_name') invalid @enderror" value="{{ old('mothers_name') }}"
            required>
        <label for="mothers_name">@lang('user.mothers_name')</label>
        @error('mothers_name')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
    <div class="input-field col s12">
        <input id="phone_number" name="phone_number" type="tel" class="validate @error('phone_number') invalid @enderror" value="{{ old('phone_number', '+36 ') }}"
            pattern="[+][0-9]{1,4}\s[(][0-9]{1,4}[)]\s[-|0-9]*" minlength="16" maxlength="18" required>
        <label for="phone_number">@lang('user.phone_number')</label>
        <span class="helper-text">+36 (20) 123-4567</span>
        @error('phone_number')
        <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                firstDay: 1,
                yearRange: 50,
                maxDate: new Date(),
            });
        });
    </script>
@endpush