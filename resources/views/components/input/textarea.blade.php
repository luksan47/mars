@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
    <textarea
        id="{{$id}}"
        {{$attributes->merge([
            'name' => $id,
            'class' => "materialize-textarea validate"
        ])}}></textarea>
    <label for="{{$id}}">{{$label}}</label>
    @error($attributes->get('value') ?? $id)
        <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
@if(!$onlyInput)
</div>
@endif
