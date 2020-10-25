@can('viewEducationalInformation', $user)
@if($user->hasEducationalInformation())
@foreach ($user->workshops as $workshop)
    <span class="new badge {{ $workshop->color() }} scale-transition" id="user-workshop-{{ $user->id }}-{{ $workshop->id }}" data-badge-caption="">
        <nobr>{{$workshop->name}} 
            @can('viewAny', \App\Models\User::class) <!-- delete button -->
                <span style="cursor: pointer;" onclick="deleteWorkshop({{ $user->id }}, {{ $workshop->id }})">&cross;</span>
            @endcan
        </nobr>
    </span>
    @if($newline ?? false)
    <br id="br-user-workshop-{{ $user->id }}-{{ $workshop->id }}">
    @endif
@endforeach

{{-- TODO: ADD SCRIPT CONTENT --}}
<script>
    function deleteWorkshop(userId, workshopId) {
        $route = "{{ route('secretariat.user.workshop.delete', ['user' => ':user', 'workshop' => ':workshop']) }}"
            .replace(':user', userId)
            .replace(':workshop', workshopId);
        $.ajax({
            type: "GET",
            url: $route,
            success: function () {
                $('#user-workshop-' + userId + '-' + workshopId).addClass("scale-out");
                //TODO remove entirely
                M.toast({html: "@lang('general.successfully_deleted')"});
            },
            error: function(error) {
                console.log("TODO");
            }
        });
    }
</script>
@endif
@endcan