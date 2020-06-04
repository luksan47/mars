<form action="{{ route('internet.mac_addresses.add') }}" method="post">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <blockquote>{{ $error }}</blockquote>
    @endforeach
    @endif
    <div class="row">
        @csrf
        <div class="input-field col s12 xl3">
            @include('select-user')
        </div>
        <div class="input-field col s12 xl3">
            <input id="mac_address" name="mac_address" type="text" placeholder="00:00:00:00:00:00"
                value="{{ old('mac_address') }}" required>
            <label for="mac_address">@lang('internet.mac_address')</label>
        </div>
        <div class="input-field col s12 xl3">
            <input id="comment" name="comment" type="text" placeholder="@lang('internet.laptop')"
                value="{{ old('comment') }}" required>
            <label for="comment">@lang('internet.comment')</label>
        </div>
        <div class="input-field col s12 xl3">
            <button type="submit" class="btn waves-effect right">@lang('internet.add')</button>
        </div>
    </div>
</form>