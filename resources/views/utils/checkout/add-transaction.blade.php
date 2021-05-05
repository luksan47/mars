@can('administrate', $checkout)
<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('checkout.income_expense')</span>
        <blockquote>@lang('checkout.add_transaction_descr')</blockquote>
        <form method="POST" action="{{ route($route_base . '.transaction.add') }}">
            @csrf
            <div class="row">
                <x-input.text m=6 l=6 id="comment" required text="checkout.description" />
                <x-input.text m=6 l=6 id="amount" required locale="checkout" />
            </div>
            <x-input.button floating class="btn=large right" icon="payments" />
        </form>
    </div>
</div>
@endcan
