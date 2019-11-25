<div class="card">
    <div class="card-header">@lang('print.send')</div>
    <div class="card-body">
        <form method="POST" action="{{ route('print.send') }}">
            @csrf
            <select class="selectpicker" data-live-search="true" id="receiver_id" name="receiver_id" title="@lang('print.user')">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <input id="balance" name="balance" type="number">
            <button type="submit" class="btn btn-primary">@lang('print.send')</button>
        </form>
    </div>
</div>