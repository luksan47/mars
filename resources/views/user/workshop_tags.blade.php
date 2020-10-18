@can('viewEducationalInformation', $user)
@if($user->hasEducationalInformation())
@foreach ($user->workshops as $workshop)
    <span class="new badge {{ $workshop->color() }}" data-badge-caption="">
        <nobr>{{$workshop->name}} <span style="cursor: pointer;">&cross;</span></nobr>
    </span>
    @if($newline ?? false)
    <br>
    @endif
@endforeach
@endif
@endcan