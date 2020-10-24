<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('checkout.gathered_transactions')</span>
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
                        <a href="{{ route($route_base . '.transaction.delete', ['transaction' => $transaction->id]) }}"
                            class="btn-floating waves-effect right red">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody></table>
            </div>
        </div>
        <form method="POST" action="{{ route($route_base . '.to_checkout') }}">
            @csrf
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
                <div class="col s7 xl8">
                    <div class="input-field">
                        <input id="password" name="password" type="password" class="validate @error('checkout_pwd') invalid @enderror" required>
                        <label for="password">@lang('checkout.password')</label>
                        @error('password')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                        @enderror
                    </div>
                </div>
                <div class="col s5 xl4">
                    <div class="input-field">
                        <button type="submit" class="btn waves-effect">
                            <i class="material-icons right">forward</i>
                            @lang('checkout.to_checkout')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>