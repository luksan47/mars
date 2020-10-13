<form action="{{ route('internet.mac_addresses.add') }}" method="post">
    <div class="row">
        @csrf
        <div class="input-field col s12 xl3">
            @include("utils.select", ['elements' => $users, 'element_id' => 'user_id'])
        </div>
        <div class="input-field col s12 xl3">
            <input id="mac_address" type="text" class="validate @error('mac_address') invalid @enderror"
                name="mac_address" placeholder="00:00:00:00:00:00" value="{{ old('mac_address') }}" required>
            <label for="mac_address">@lang('internet.mac_address')</label>
            @error('mac_address')
            <span class="helper-text" data-error="{{ $message }}"></span>
            @enderror
        </div>
        <div class="input-field col s12 xl3">
            <input id="comment" type="text" class="validate @error('comment') invalid @enderror" name="comment" placeholder="@lang('internet.laptop')"
                value="{{ old('comment') }}" required>
            <label for="mac_address">@lang('internet.comment')</label>
            @error('comment')
            <span class="helper-text" data-error="{{ $message }}"></span>
            @enderror
        </div>
        <div class="input-field col s12 xl3">
            <button type="submit" class="btn waves-effect right">@lang('internet.add')</button>
        </div>
    </div>
</form>