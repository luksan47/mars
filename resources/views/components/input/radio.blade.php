@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}"><p>
@endif
<label>
    <input
        type="radio"
        {{$attributes}}
    >
    <span>{{$label}}</span>
</label>
@if(!$onlyInput)
</p></div>
@endif
