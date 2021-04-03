{{-- Do not forget to add "enctype='multipart/form-data'" to the form! --}}

<div class="file-field input-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
    <div class="btn waves-effect">
        <span>File</span>
        <input
            type="file"
            id="{{$id}}"
            {{$attributes->merge([
                'name' => $id
            ])}}
        >
    </div>
    <div class="file-path-wrapper">
        <input
            class="file-path @error($id) invalid @enderror"
            placeholder="@lang($lang)"
            type="text"
            disabled>
        @error($id)
            <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
</div>
