@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
    <select
        searchable="@lang('general.search')"
        id="{{ $id }}"
        {{-- Required is not supported because the select does not support validation --}}
        {{$attributes->whereDoesntStartWith('required')->merge([
            'name' => $id
        ])}}
        >
        @if(!$withoutPlaceholder)
        <option
            value=""
            disabled="true"
            selected="true">
            @lang('general.choose_option')
        </option>
        @endif
        @foreach ($elements as $element)
            <option
                value="{{ $element->id ?? $element }}"
                @if($default != null && (($element->id ?? $element) == $default)) selected="true" @endif>
                {{ $element->name ?? $element }}
            </option>
        @endforeach
    </select>

    <label for="{{$id}}">{{$label}}</label>
    @error($attributes->get('value') ?? $id)
        <span class="helper-text red-text">{{ $message }}</span>
    @enderror
@if(!$onlyInput)
</div>
@endif

@push('scripts')
    <script>
        //Initialize materialize select
        var instances;
        $(document).ready(
        function() {
            var elems = $('#{{ $id }}');
            const options = [
            @foreach ($elements as $element)
                { name : '{{ $element->name ?? $element }}',  value : '{{ $element->id ?? $element }}'},
            @endforeach
            ];
            instances = M.FormSelect.init(elems, options);
        });
  </script>
@endpush
