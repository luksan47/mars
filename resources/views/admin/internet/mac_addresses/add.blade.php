<form action="{{ route('internet.mac_addresses.add') }}" method="post">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-row align-items-center">
        @csrf
        <div class="col-auto">
            <label for="inlineFormInput">@lang('internet.user_id')</label> {{-- TODO: Better user selection --}}
            <input type="text" class="form-control mb-2" name="user_id" placeholder="1" value="{{ old('user_id') }}">
        </div>
        <div class="col-auto">
            <label for="inlineFormInput">@lang('internet.mac_address')</label>
            <input type="text" class="form-control mb-2" name="mac_address" placeholder="00:00:00:00:00:00" value="{{ old('mac_address') }}">
        </div>
        <div class="col-auto">
            <label for="inlineFormInput">@lang('internet.comment')</label>
            <input type="text" class="form-control mb-2" name="comment" placeholder="@lang('internet.laptop')" value="{{ old('comment') }}">
        </div>
        <div class="col-auto">
            <label>&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary mb-2">@lang('internet.add')</button>
        </div>
    </div>
</form>
