@foreach($roles->chunkWhile(function($current, $key, $chunk) {
    return $current->name() === $chunk->last()->name();
}) as $rolegroup)
<span class="new badge {{ $rolegroup->first()->color() }}" data-badge-caption="">
    <nobr>{{ $rolegroup->first()->name() }}</nobr>
</span>
    @foreach($rolegroup as $role)
    @if($role->object())
    <span class="new badge {{ $rolegroup->first()->color() }}" data-badge-caption="">
    <nobr>: {{ $role->object()->name }}</nobr>
    </span>
    @endif
    @endforeach
@if($newline ?? false)
<br>
@endif
@endforeach
