<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('checkout.my_gathered_transactions')</span>
        <div class="row">
            <div class="col s12">
            <table><tbody>
                @foreach($user_transactions_not_in_checkout as $transaction)
                <tr>
                    <td>
                        @if($transaction->payer)
                            {{ $transaction->payer->name }}
                        @endif
                    </td>
                    <td>
                        {{ $transaction->type->name }}
                    </td>
                    <td>{{ $transaction->amount }} Ft</td>
                    <td>
                        @can('delete', $transaction)
                        <a href="{{ route($route_base . '.transaction.delete', ['transaction' => $transaction->id]) }}"
                            class="btn-floating waves-effect right red">
                            <i class="material-icons">delete</i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody></table>
            </div>
        </div>
        <div class="row">
            <div class="col s8">
                <b>@lang('checkout.sum')</b>
            </div>
            <div class="col s4">
                <b>{{ $user_transactions_not_in_checkout->sum('amount') }} Ft</b>
            </div>
            <div class="col s12">
                <blockquote>@lang('checkout.collecting_kktnetreg_description')</blockquote>
            </div>
        </div>
    </div>
</div>
