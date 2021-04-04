@if(!$onlyInput && !$attributes->get('href'))
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif

@if($attributes->get('href'))
<a href="{{$attributes->get('href')}}"
@else
<button
@endif
    {{$attributes->whereDoesntStartWith('href')->merge([
        'type' => 'submit',
        'class' => 'waves-effect '.($floating ? "btn-floating" : 'btn')
    ])}}
>
@if($icon)
<i class="material-icons">{{$icon}}</i>
@else
{{$label}}
@endif

@if($attributes->get('href'))
</a>
@else
</button>
@endif

@if(!$onlyInput && !$attributes->get('href'))
</div>
@endif
