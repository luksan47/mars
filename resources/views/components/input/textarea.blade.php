@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
    <textarea
        id="{{$id}}"
        {{$attributes->whereDoesntStartWith('value')->merge([
            'name' => $id,
            'class' => "materialize-textarea validate"
        ])}}>{{old($id) ?? $attributes->get('value')}}</textarea>
    <label for="{{$id}}">{{$label}}</label>
    @if($helper ?? null)
    <span class="helper-text">{{ $helper }}</span>
    @endif
    @error($attributes->get('value') ?? $id)
        <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
@if(!$onlyInput)
</div>
@endif
