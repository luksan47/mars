@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}"><p>
@endif
<label>
    <input
        type="checkbox"
        {{$attributes->merge([
            'classs' => "filled-in checkbox-color"
        ])}}
    >
    <span>{{$label}}</span>
</label>
@if(!$onlyInput)
</p></div>
@endif
