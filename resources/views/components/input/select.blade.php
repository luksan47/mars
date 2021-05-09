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
        @if($allowEmpty)
        <option value=null></option>
        @endif
        @foreach ($elements as $element)
            <option
                value="{{ $element->id ?? $element }}"
                @if($default != null && (($element->id ?? $element) == $default || ($element->name ?? $element) == $default)) selected="true" @endif
                >@lang($element->name ?? $element)</option>
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

@if ($once)
  @once
    @include('components.input.init.select')
  @endonce
@else
  @include('components.input.init.select')
@endif