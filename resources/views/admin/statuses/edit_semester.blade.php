{{-- Input: $user and $semester --}}
<tr>
    <td>
        <b>{{ $semester->tag() }}</b>
    </td>
    <td>
        <span class="new badge {{ \App\Models\Semester::colorForStatus($user->getStatusIn($semester)) }}" data-badge-caption="">
            @lang("user." . $user->getStatusIn($semester))
        </span>
    </td>
    <td>
        <div class="right">
            @include('admin.statuses.edit_buttons', ['user' => $user, 'semester' => $semester])
        </div>
    </td>
</tr>