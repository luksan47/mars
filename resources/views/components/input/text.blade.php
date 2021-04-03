<div class="input-field col s{{$s}} m{{$m}} l{{$l}}">
    <input
        id="{{$id}}"
        name="{{$id}}"
        class="validate @error($id) invalid @enderror"
        {{-- defeault values --}}
        {{$attributes->merge([
            'type' => 'text',
            'value' => old($id),
        ])}}
        {{-- this also adds other provided values --}}
    >
    <label for="{{$id}}">@lang($lang)</label>
    @error($id)
        <span class="helper-text" data-error="{{ $message }}"></span>
    @enderror
</div>
