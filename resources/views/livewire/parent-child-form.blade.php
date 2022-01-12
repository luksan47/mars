<div>
    @if($optional)
    <div class="input-field col s3" style="padding: 0">
        <p>
            <label>
                <input type="checkbox" class="filled-in checkbox-color" @if(!$hidden) checked @endif wire:click="show">
                <span>{{ $title }}</span>
            </label>
        </p>
    </div>
    @else
    <div class="input-field col s3" style="padding-left: 25px">
        <label style="position: inherit;">{{$title}}</label>
    </div>
    @endif
    @if (!$hidden)
        <div class="col s9">
            @foreach ($items as $index => $item)
                <div class="row" style="margin:0">
                    <div class="input-field col s11" style="margin:0">
                        <input class="validate" name="{{ $name }}[]" wire:model="items.{{ $index }}" placeholder="{{ $loop->iteration }}.">
                        @if($loop->last && $helper ?? null)
                            <span class="helper-text">{{ $helper }}</span>
                        @endif
                    </div>
                    @if($loop->last)
                        <x-input.button wire:click.prevent="addItem" type="button" s="1" class="right" floating icon="add" />
                    @else
                        <x-input.button wire:click.prevent="removeItem({{$index}})" type="button" s="1" class="right red" floating icon="remove" />
                    @endif
                </div>
            @endforeach

        </div>

    @endif

</div>
