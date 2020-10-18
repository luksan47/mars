@can('viewAny', \App\Models\User::class)
<form method="POST" action="{{ route('secretariat.user.workshop.add', ['user' => $user]) }}">
    @csrf
    <div class="input-field col s10">
        @include("utils.select", ['elements' => \App\Models\Workshop::all()->diff($user->workshops), 'element_id' => 'workshop_id', 'label' => __('general.add_new'), 'required' => true])
    </div>
    <div class="input-field col s2">
        <button type="submit" class="btn-floating waves-effect waves-light right green">
            <i class="material-icons">add</i>
        </button>
    </div>
</form
@endcan