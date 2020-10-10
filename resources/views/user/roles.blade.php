@foreach($roles->chunkWhile(function($current, $key, $chunk) {
    return $current->name() === $chunk->last()->name();
}) as $rolegroup)
<span class="new badge {{ $rolegroup->first()->color() }}" data-badge-caption="">
    {{ $rolegroup->first()->name() }}
</span>
    @foreach($rolegroup as $role)
    @if($role->object())
    <span class="new badge {{ $rolegroup->first()->color() }}" data-badge-caption="">
    : {{ $role->object()->name }}
    </span>
    @endif
    @endforeach
@if($newline ?? false)
<br>
@endif
@endforeach
