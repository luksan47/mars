<div class="input-field col s{{$s}} m{{$m}} l{{$l}}">
    <input
        type="text"
        class="datepicker_{{$id}} validate @error($id) invalid @enderror"
        id="{{$id}}"
        name="{{$id}}"
        value="{{ old($id) }}"
        onfocus="M.Datepicker.getInstance({{$id}}).open();"
        {{$attributes}}
    >
    <label for="{{$id}}">@lang($lang)</label>
    @error($id)
    <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datepicker_{{$id}}').datepicker({
                format: '{{$format}}',
                firstDay: 1,
                yearRange: {{$yearRange}},
                maxDate: new Date(),
            });
        });
    </script>
@endpush
