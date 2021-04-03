@if(!$onlyInput)
<div class="input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
<button
    {{$attributes->merge([
        'type' => 'submit',
        'class' => 'btn waves-effect'
    ])}}
>
@lang($text)
</button>
@if(!$onlyInput)
</div>
@endif
