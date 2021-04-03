@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
<button
    {{$attributes->merge([
        'type' => 'submit',
        'class' => 'btn waves-effect'
    ])}}
>
{{$label}}
</button>
@if(!$onlyInput)
</div>
@endif
