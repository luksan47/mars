@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
    <input
        type="text"
        class="timepicker validate @error($id) invalid @enderror"
        id="{{$id}}"
        onfocus="M.Timepicker.getInstance('{{$id}}').open();"
        value="{{old($id) ?? $attributes->get('value')}}"
        {{-- Default values + other provided attributes --}}
        {{$attributes->whereDoesntStartWith('value')->merge([
            'name' => $id
        ])}}
    >
    <label for="timepicker_{{$id}}">{{$label}}</label>
    @error($attributes->get('value') ?? $id)
    <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
@if(!$onlyInput)
</div>
@endif

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.timepicker').timepicker({
                showClearBtn: true,
                twelveHour: false,
            });
        });
    </script>
@endpush
