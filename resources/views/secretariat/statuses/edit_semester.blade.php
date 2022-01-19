{{-- Input: $user and $semester --}}
<tr>
    <td>
        <b>{{ $semester->tag }}</b>
    </td>
    <td>
        @livewire('edit-status', ['user' => $user, 'semester' => $semester])
    </td>
</tr>
