@can('viewEducationalInformation', $user)
@if($user->hasEducationalInformation())
@foreach ($user->workshops as $workshop)
    <span class="new badge {{ $workshop->color() }}" id="user-workshop-{{ $user->id }}-{{ $workshop->id }}" data-badge-caption="">
        <nobr>{{$workshop->name}} <span style="cursor: pointer;" onclick="valami({{ $user->id }}, {{ $workshop->id }})">&cross;</span></nobr>
    </span>
    @if($newline ?? false)
    <br id="br-user-workshop-{{ $user->id }}-{{ $workshop->id }}">
    @endif
@endforeach

{{-- TODO: ADD SCRIPT CONTENT --}}
<script>
    function valami(userId, workshopId) {
        console.log(userId, workshopId);
        $route = "{{ route('secretariat.user.workshop.delete', ['user' => ':user', 'workshop' => ':workshop']) }}"
            .replace(':user', userId)
            .replace(':workshop', workshopId);
        $.ajax({
            type: "GET",
            url: $route,
            success: function () {
                $('#user-workshop-' + userId + '-' + workshopId).remove();
                $('#br-user-workshop-' + userId + '-' + workshopId).remove();
            },
            error: function(error) {
                console.log("TODO");
            }
        });
    }
</script>
@endif
@endcan