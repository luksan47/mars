<form action="{{ route('internet.mac_addresses.add') }}" method="post">
    <div class="form-row align-items-center">
        @csrf
        <div class="row">
            <div class="input-field col s12">
                <input id="mac_address" type="text" class="validate" name="mac_address" placeholder="00:00:00:00:00:00" value="{{ old('mac_address') }}">
                <label for="mac_address">@lang('internet.mac_address')</label>
                @error('mac_address')
                    <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="comment" type="text" class="validate" name="comment" placeholder="@lang('internet.laptop')" value="{{ old('comment') }}">
                <label for="mac_address">@lang('internet.comment')</label>
                @error('comment')
                    <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button class="btn waves-effect secondary-color" type="submit" >@lang('internet.add')</button>
            </div>
        </div>
    </div>
</form>
