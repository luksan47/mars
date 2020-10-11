@can('viewEducationalInformation', $user)
@if($user->hasEducationalInformation())
@foreach ($user->workshops as $workshop)
    <span class="new badge {{ $workshop->color() }}" data-badge-caption="">
        <nobr>{{$workshop->name}}</nobr>
    </span>
    @if($newline ?? false)
    <br>
    @endif
@endforeach
@endif
@endcan