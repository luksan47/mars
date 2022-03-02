<div>
    @can('viewPermissionFor', $user)
    <div class="switch">
        <label>
        @lang('role.extern')
        <input type="checkbox" wire:click="switch"
            @if($user->isResident()) checked @endif >
        <span class="lever"></span>
        @lang('role.resident')
        </label>
    </div>
    @endcan
</div>
