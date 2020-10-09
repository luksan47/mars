@foreach($roles as $role)
<span class="new badge {{ $role->color() }}" data-badge-caption="">{{ $role->name() }}
    @if($role->pivot->object_id)
        : {{ $role->object()->name }}
    @endif
</span>
@if($newline ?? false)
<br>
@endif
@endforeach
