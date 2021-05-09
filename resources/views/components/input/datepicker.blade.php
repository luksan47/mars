@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
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
    @error($attributes->get('value') ?? $id)
    <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
@if(!$onlyInput)
</div>
@endif

@include('components.input.init.datepicker')