{{-- needs js tooltip initializer --}}
<x-input.button
    :href="route('secretariat.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::ACTIVE])"
    floating
    class="green tooltipped"
    data-position="bottom"
    :data-tooltip="__('user.ACTIVE')"
    icon="rowing"/>
<x-input.button
    :href="route('secretariat.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::INACTIVE])"
    floating
    class="grey tooltipped"
    data-position="bottom"
    :data-tooltip="__('user.INACTIVE')"
    icon="power"/>
<x-input.button
    :href="route('secretariat.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::DEACTIVATED])"
    floating
    class="red tooltipped"
    data-position="bottom"
    :data-tooltip="__('user.DEACTIVATED')"
    icon="directions_run"/>
<x-input.button
    :href="route('secretariat.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Models\Semester::PASSIVE])"
    floating
    class="tooltipped"
    data-position="bottom"
    :data-tooltip="__('user.PASSIVE')"
    icon="self_improvement"/>
