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
@if(!$onlyInput)
</div>
@endif
