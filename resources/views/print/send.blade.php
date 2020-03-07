<div class="card">
    <div class="card-header">@lang('print.transfer_money')</div>
    <div class="card-body">
        <div class="alert alert-info">
            @lang('print.how_transfer_works')
        </div>
        <form method="POST" action="{{ route('print.transfer-balance') }}">
            @csrf
            <select class="selectpicker" data-live-search="true" id="receiver_id" name="receiver_id" title="@lang('print.user')">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <input id="balance" name="balance" type="number" placeholder="@lang('print.amount')">
            <button type="submit" class="btn btn-primary">@lang('print.send')</button>
        </form>
    </div>
</div>