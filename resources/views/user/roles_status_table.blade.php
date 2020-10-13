<table>
<tbody>
    <tr>
        <th>@lang('role.roles')</th>
        <td>@include('user.roles', ['roles' => $user->roles, 'newline' => $newline ?? false])</td>
        <td>
        @can('viewPermissionFor', $user)
            <a href="{{ route('admin.permissions.show', $user->id) }}"
                class="btn-floating waves-effect waves-light right">
                <i class="material-icons">edit</i>
            </a>
        @endcan
        </td>
    </tr>
    <tr>
        <th>@lang('user.status')</th>
        <td>
            <span class="new badge {{ \App\Models\Semester::colorForStatus($user->getStatus()) }}" data-badge-caption="">
                @lang("user." . $user->getStatus())
            </span></td>
        <td>
        @can('viewPermissionFor', $user) {{-- ??? --}}
            <a href="{{ route('admin.user.semesters', ['id' => $user->id]) }}" class="btn-floating waves-effect right">
                <i class="material-icons">edit</i></a>
        @endcan
        </td>
    </tr>
</tbody>
</table>