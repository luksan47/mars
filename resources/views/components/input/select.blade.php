@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
    <select
        searchable="@lang('general.search')"
        id="{{ $id }}"
        {{-- Required is not supported because the select does not support validation --}}
        {{$attributes->whereDoesntStartWith('required')->whereDoesntStartWith('placeholder')->merge([
            'name' => $id
        ])}}
        >
        @if(!$withoutPlaceholder)
        <option
            value=""
            disabled="true"
            selected="true">
            {{ $attributes->get('placeholder') ?? __('general.choose_option') }}
        </option>
        @endif
        @foreach ($elements as $element)
            <option
                value="{{ $element->id ?? $element }}"
                @if($default != null && (($element->id ?? $element) == $default || ($element->name ?? $element) == $default)) selected="true" @endif>
                @lang($element->name ?? $element)
            </option>
        @endforeach
    </select>
    @if(!$withoutLabel)
    <label for="{{$id}}">{{$label}}</label>
    @endif
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
