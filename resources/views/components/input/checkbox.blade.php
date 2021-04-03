@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}"><p>
@endif
<label>
    <input
        type="checkbox"
        {{$attributes}}
        class="filled-in checkbox-color"
    >
    <span>@lang($text)</span>
</label>
@if(!$onlyInput)
</p></div>
@endif
