{{--TODO disable on unapproved users because it fails--}}
@can('viewAny', \App\Models\User::class)
<form method="POST" action="{{ route('secretariat.user.workshop.add', ['user' => $user]) }}">
    @csrf
    <x-input.select s=10 :elements="\App\Models\Workshop::all()->diff($user->workshops)" id="workshop_id" :placeholder="__('general.add_new')" without_label/>
    <x-input.button floating class="right green" icon="add" />
</form
@endcan
