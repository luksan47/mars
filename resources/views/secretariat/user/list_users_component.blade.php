<div>
<table>

    {{-- Filter --}}
    <h6>@lang('general.filter')</h6>

    <div class="row">
        <div class="col">
            <input type="text" class="input-field" id="filter_name" placeholder="@lang('user.name')" wire:model="filter_name" />
            <p>
                @lang('role.roles'):
                @foreach (\App\Models\Role::all() as $r)
                    @if(in_array($r->id, $this->roles))
                    <span class="new badge {{ $r->color() }}" data-badge-caption=""
                        style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer;"
                        wire:click="deleteRole({{$r->id}})">
                        <nobr><i>{{ $r->name() }}</i> &cross;</nobr>
                    </span>
                    @else
                    <span class="new badge {{ $r->color() }}" data-badge-caption=""
                        style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer"
                        wire:click="addRole({{$r->id}})">
                        <nobr>{{ $r->name() }}</nobr>
                    </span>
                    @endif
                @endforeach

            </p>
            <hr>
            <p>
                @lang('user.workshops'):
                @foreach (\App\Models\Workshop::all() as $w)
                    @if(in_array($w->id, $this->workshops))
                    <span class="new badge {{ $w->color() }}" data-badge-caption=""
                        style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer;"
                        wire:click="deleteWorkshop({{$w->id}})">
                        <nobr><i>{{ $w->name }}</i> &cross;</nobr>
                    </span>
                    @else
                    <span class="new badge {{ $w->color() }}" data-badge-caption=""
                        style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer"
                        wire:click="addWorkshop({{$w->id}})">
                        <nobr>{{ $w->name }}</nobr>
                    </span>
                    @endif
                @endforeach
            </p>
            <hr>
            <p>
                @lang('admin.statuses'):
                @foreach (\App\Models\Semester::STATUSES as $s)
                    @if(in_array($s, $this->statuses))
                    <span class="new badge {{ \App\Models\Semester::colorForStatus($s) }}" data-badge-caption=""
                        style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer;"
                        wire:click="deleteStatus('{{$s}}')">
                        <nobr><i>@lang('user.'.$s)</i> &cross;</nobr>
                    </span>
                    @else
                    <span class="new badge {{ \App\Models\Semester::colorForStatus($s) }}" data-badge-caption=""
                        style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer"
                        wire:click="addStatus('{{$s}}')">
                        <nobr>@lang('user.'.$s)</nobr>
                    </span>
                    @endif
                @endforeach
            </p>
        </div>
    </div>

    {{-- List --}}
    <thead>
        <tr>
            <th>@lang('print.user')</th>
            <th>
                @lang('user.workshops')
            </th>
            <th colspan="3">
                <x-input.button :href="route('secretariat.permissions.list')" text="role.roles" />
                <x-input.button :href="route('secretariat.user.statuses')" class="right" text="admin.statuses" />
            </th>
    </thead>
    <tbody>
        @foreach ($this->users as $user)
        @can('view', $user)
        <tr>
            <td>
                <b>{{ $user->name }}</b><br>
                {{ $user->email }}
                @if($user->hasEducationalInformation())
                <br>{{ $user->educationalInformation->neptun ?? '' }}
                @endif
            </td>
            <!-- Workshops -->
            <td>
                @if($user->hasEducationalInformation())
                @can('viewEducationalInformation', $user)
                    @include('user.workshop_tags', ['user' => $user, 'newline' => true])
                @endcan
                @endif
            </td>
            <!-- Roles -->
            <td>
                <!-- TODO policy -->
                @include('user.roles', [
                    'roles' => $user->roles->whereNotIn('name', ['internet-user', 'printer']),
                    'newline' => true
                ])
            </td>
            <!-- Status -->
            <td>
                @if($user->hasEducationalInformation())
                @can('viewEducationalInformation', $user)
                <span class="new badge {{ \App\Models\Semester::colorForStatus($user->getStatus()) }}" data-badge-caption="">
                    @lang("user." . $user->getStatus())
                </span>
                @endcan
                @endif
            </td>
            <!-- Edit -->
            <td>
                <div class="right">
                    <a href="{{ route('secretariat.user.show', ['id' => $user->id]) }}" class="btn-floating waves-effect">
                        <i class="material-icons">remove_red_eye</i></a>
                </div>
            </td>
        </tr>
        @endcan
        @endforeach
    </tbody>
</table>
</div>
