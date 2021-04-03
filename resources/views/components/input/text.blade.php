@if(!$onlyInput)
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
    <label for="{{$id}}">@lang($lang)</label>
    @if($message ?? null)
    <span class="helper-text">{{ $message }}</span>
    @endif
    @error($id)
        <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
@if(!$onlyInput)
</div>
@endif
