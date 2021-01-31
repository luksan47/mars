@can('administrate', $checkout)
<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('checkout.income_expense')</span>
        <blockquote>@lang('checkout.add_transaction_descr')</blockquote>
        <form method="POST" action="{{ route($route_base . '.transaction.add') }}">
            @csrf
            <div class="row">
                <div class="col s12">
                    <div class="input-field col s12 m6 l6">
                        <input id="comment" name="comment" type="text" required>
                        <label for="comment">@lang('checkout.description')</label>
                        @error('comment')
                        <span class="helper-text" data-error="{{ $message }}"></span>
                        @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <input id="amount" name="amount" type="number" required>
                        <label for="amount">@lang('checkout.amount')</label>
                        @error('amount')
                        <span class="helper-text" data-error="{{ $message }}"></span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-floating btn-large waves-effect right"><i class="large material-icons">payments</i></button>
        </form>
    </div>
</div>
@endcan
