@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
<button
    {{$attributes->merge([
        'type' => 'submit',
        'class' => 'waves-effect '.($floating ? "btn-floating" : 'btn')
    ])}}
>
@if($icon)
<i class="material-icons">{{$icon}}</i>
@else
{{$label}}
@endif
</button>
@if(!$onlyInput)
</div>
@endif
