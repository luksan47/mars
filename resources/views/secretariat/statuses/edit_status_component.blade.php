<div>
    <button
        class="green tooltipped waves-effect btn-floating"
        wire:click="set('ACTIVE')"
        data-position="bottom"
        data-tooltip="{{__('user.ACTIVE')}}">
            <i class="material-icons">rowing</i>
    </button>
    <button
        class="grey tooltipped waves-effect btn-floating"
        wire:click="set('INACTIVE')"
        data-position="bottom"
        data-tooltip="{{__('user.INACTIVE')}}">
            <i class="material-icons">power</i>
    </button>
    <button
        class="tooltipped waves-effect btn-floating"
        wire:click="set('PASSIVE')"
        data-position="bottom"
        data-tooltip="{{__('user.PASSIVE')}}">
            <i class="material-icons">self_improvement</i>
    </button>
    <button
        class="red tooltipped waves-effect btn-floating"
        wire:click="set('DEACTIVATED')"
        data-position="bottom"
        data-tooltip="{{__('user.DEACTIVATED')}}">
            <i class="material-icons">directions_run</i>
    </button>

    <span class="new badge {{ \App\Models\Semester::colorForStatus($status) }}" data-badge-caption="" style="margin-left:10px">
        @lang("user." . $status)
    </span>
</div>
