{{-- Input: $user and $semester --}}
<tr>
    <td>
        <b>{{ $semester->tag() }}</b>
    </td>
    <td>
        <span class="new badge {{ \App\Semester::colorForStatus($user->getStatusIn($semester)) }}" data-badge-caption="">
            @lang("user." . $user->getStatusIn($semester))
        </span>
    </td>
    <td>
        <div class="right">
            <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::ACTIVE]) }}" class="btn-floating green waves-effect tooltipped" data-position="bottom"  data-tooltip="@lang('user.ACTIVE')">
                <i class="material-icons">rowing</i></a>
            <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::INACTIVE]) }}" class="btn-floating grey waves-effect tooltipped" data-tooltip="@lang('user.INACTIVE')">
                <i class="material-icons">power</i></a>
            <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::DEACTIVATED]) }}" class="btn-floating red waves-effect tooltipped" data-tooltip="@lang('user.DEACTIVATED')">
                <i class="material-icons">directions_run</i></a>
            <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::PASSIVE]) }}" class="btn-floating waves-effect tooltipped" data-tooltip="@lang('user.PASSIVE')">
                <i class="material-icons">self_improvement</i></a>
        </div>
    </td>
</tr>
<script>
    $(document).ready(function(){
        $('.tooltipped').tooltip();
    });
</script>