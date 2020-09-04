{{-- This should be in a tr --}}
<td>
    @foreach($user->roles as $role)
    <span class="new badge {{ $role->color() }}" data-badge-caption="">{{ $role->name() }}
        @if($role->pivot->object_id)
            : {{ $role->object()->name }}
        @endif
    </span>
    @endforeach
</td>
<td>
    <a href="{{ route('admin.permissions.show', $user->id) }}"
        class="btn-floating waves-effect waves-light right" @cannot('view', $user) disabled @endcan>
        <i class="material-icons">edit</i>
    </a>
</td>
