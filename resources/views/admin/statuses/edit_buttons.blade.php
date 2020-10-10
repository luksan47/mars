<a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::ACTIVE]) }}" class="btn-floating green waves-effect tooltipped" data-position="bottom"  data-tooltip="@lang('user.ACTIVE')">
    <i class="material-icons">rowing</i></a>
<a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::INACTIVE]) }}" class="btn-floating grey waves-effect tooltipped" data-tooltip="@lang('user.INACTIVE')">
    <i class="material-icons">power</i></a>
<a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::DEACTIVATED]) }}" class="btn-floating red waves-effect tooltipped" data-tooltip="@lang('user.DEACTIVATED')">
    <i class="material-icons">directions_run</i></a>
<a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::PASSIVE]) }}" class="btn-floating waves-effect tooltipped" data-tooltip="@lang('user.PASSIVE')">
    <i class="material-icons">self_improvement</i></a>
{{-- needs js tooltip initializer --}}