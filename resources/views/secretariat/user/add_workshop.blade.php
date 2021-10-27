{{--TODO disable on unapproved users because it fails--}}
@can('viewAny', \App\Models\User::class)
<form method="POST" action="{{ route('secretariat.user.workshop.add', ['user' => $user]) }}">
    @csrf
    <select id="workshop_id" class="browser-default" name="workshop_id">
      <option value="" selected disabled>@lang('general.add_new')</option>
      @for ($i=0; $i < count($workshops); $i++)
        <option value="{{$workshops[$i]->id}}">@lang('role.'.$workshops[$i]->name)</option>
      @endfor
    </select>
    <x-input.button floating class="right green" icon="add" />
</form
@endcan
