@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}"><p>
@endif
    <input
        type="text"
        class="datepicker_{{$id}} validate @error($id) invalid @enderror"
        id="{{$id}}"
        onfocus="M.Datepicker.getInstance({{$id}}).open();"
        value="{{old($id) ?? $attributes->get('value')}}"
        {{-- Default values + other provided attributes --}}
        {{$attributes->whereDoesntStartWith('value')->merge([
            'name' => $id
        ])}}
    >
    <label for="{{$id}}">{{$label}}</label>
    @error($id)
    <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
@if(!$onlyInput)
</div>
@endif

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datepicker_{{$id}}').datepicker({
                format: '{{$format}}',
                firstDay: 1,
                yearRange: {{$yearRange}},
            });
        });
    </script>
@endpush
