<table>
<tbody>
    <tr>
        <th>@lang('role.roles')</th>
        <td>@include('user.roles', ['roles' => $user->roles, 'newline' => $newline ?? false])</td>
        <td>
        @can('viewPermissionFor', $user)
            <x-input.button :href="route('secretariat.permissions.show', $user->id)"
                floating class="right" icon="edit"/>
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
            <x-input.button :href="route('secretariat.user.semesters', ['id' => $user->id])" floating class="right" icon="edit"/>
        @endcan
        </td>
    </tr>
</tbody>
</table>