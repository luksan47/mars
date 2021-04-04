@if(!$onlyInput && !$attributes->get('hidden'))
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
    <input
        id="{{$id}}"
        class="validate @error($id) invalid @enderror"
        value="{{old($id) ?? $attributes->get('value')}}"
        {{-- Default values + other provided attributes --}}
        {{$attributes->whereDoesntStartWith('value')->merge([
            'type' => 'text',
            'name' => $id
        ])}}
    >
    @if(!$attributes->get('hidden'))
    <label for="{{$id}}">{{$label}}</label>
    @endif
    @if($helper ?? null)
    <span class="helper-text">{{ $helper }}</span>
    @endif
    @error($attributes->get('value') ?? $id)
        <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
@if(!$onlyInput && !$attributes->get('hidden'))
</div>
@endif
