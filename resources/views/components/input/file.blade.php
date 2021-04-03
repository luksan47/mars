{{-- Do not forget to add "enctype='multipart/form-data'" to the form! --}}

@if(!$onlyInput)
<div class="input-field file-field col s{{$s}} m{{$m}} l{{$l}} xl{{$xl}}">
@endif
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
            placeholder="{{$label}}"
            type="text"
            disabled>
        @error($id)
            <span class="helper-text" data-error="{{ $message }}"></span>
        @enderror
    </div>
@if(!$onlyInput)
</div>
@endif
