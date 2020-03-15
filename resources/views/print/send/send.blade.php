<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.transfer_money')</span>
        <form method="POST" action="{{ route('print.transfer-balance') }}">
            @csrf
            <div class="row">
                <div class="input-field col s12 m12 l5">
                    @include("select-user")
                </div>
                <div class="input-field col s12 m12 l5">
                    <input id="balance" name="balance" type="number" min="0" value="{{ old('balance') }}" required>
                    <label for="balance">@lang('print.amount')</label>
                </div>
                <div class="input-field col s12 m12 l2">
                    <button class="btn waves-effect right" type="submit">@lang('print.send')</button>
                </div>
            </div>
        </form>
    </div>
</div>