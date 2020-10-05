@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.checkout')</a>
@endsection
@section('admin_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.checkout')</span>
                <blockquote>
                    @lang('checkout.current_balance'): 
                    <b class="coli-text text-orange"> {{ number_format($current_balance, 0, '.', ' ') }} Ft</b>.<br>
                    @lang('checkout.current_balance_in_checkout'): 
                    <b class="coli-text text-orange"> {{ number_format($current_balance_in_checkout, 0, '.', ' ') }} Ft</b>.<br>
                </blockquote>
                @if(Auth::user()->isSysAdmin())
                <div class="row">
                    <div class="col s12 xl6">
                        <span class="card-title">@lang('checkout.new_transaction')</span>
                        <blockquote>@lang('checkout.add_transaction_descr')</blockquote>
                        <form method="POST" action="{{ route('admin.checkout.transaction.add') }}">
                            @csrf
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field col s12 m4 l4">
                                        <input id="comment" name="comment" type="text" required>
                                        <label for="comment">@lang('checkout.description')</label>
                                        @error('comment')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12 m4 l4">
                                        <input id="amount" name="amount" type="number" required>
                                        <label for="amount">@lang('checkout.amount')</label>
                                        @error('amount')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12 m4 l4">
                                        <input id="password" name="password" type="password" required>
                                        <label for="password">@lang('checkout.password')</label>
                                        @error('password')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="center-align">
                                <button type="submit" class="btn waves-effect">@lang('print.add')</button>   
                            </div>
                        </form>
                    </div>
                    <div class="col s12 xl6">
                        <span class="card-title">@lang('checkout.print')</span>
                        <div class="row">
                            <div class="col s12">
                            <table>
                                <tbody>
                                    @foreach($my_transactions as $transaction)
                                    <tr>
                                        @if($transaction->payer)
                                        <td>{{ $transaction->payer->name }}</td>
                                        @else <td></td> @endif
                                        <td class="right">{{ $transaction->amount }} Ft</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                            <b>@lang('checkout.sum')</b>
                                        </td>
                                        <td>
                                            <b class="right">{{ $sum_my_transactions }} Ft</b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.checkout.print_to_checkout') }}">
                            @csrf
                            <div class="row">
                                <div class="col s7 xl8">
                                    <div class="input-field">
                                        <input id="password2" name="password" type="password" class="validate @error('checkout_pwd') invalid @enderror" required>
                                        <label for="password2">@lang('checkout.password')</label>
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
                @endif
            </div>
        </div>
    </div>
</div>

@foreach($data as $semester => $row)

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">  
                <span class="card-title">{{ $semester }}</span>
                <div class="row">
                    <div class="col s12">
                        <table><tbody>
                            <tr><th colspan="3">@lang('checkout.incomes')</th></tr>
                            <tr>
                                <td>@lang('checkout.netreg')</td>
                                <td></td>
                                <td class="right"><nobr>{{ number_format($row['transactions']['netreg'], 0, '.', ' ') }} Ft</nobr></td>
                            </tr>
                            <tr>
                                <td>@lang('checkout.print')</td>
                                <td></td>
                                <td class="right"><nobr>{{ number_format($row['transactions']['print'], 0, '.', ' ') }} Ft</nobr></td>
                            </tr>
                            @foreach($row['transactions']['income'] as $transaction)
                            <tr>
                                <td>{{ $transaction->comment }}</td>
                                <td>{{ $transaction->created_at->format('Y. m. d.') }}</td>
                                <td class="right"><nobr>{{ number_format($transaction->amount, 0, '.', ' ') }} Ft</nobr></td>
                            </tr>
                            @endforeach
                            <tr><th colspan="3">@lang('checkout.expenses')</th></tr>
                            @foreach($row['transactions']['expense'] as $transaction)
                            <tr>
                                <td>{{ $transaction->comment }}</td>
                                <td>{{ $transaction->created_at->format('Y. m. d.') }}</td>
                                <td class="right"><nobr>{{ number_format($transaction->amount, 0, '.', ' ') }} Ft</nobr></td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="2">@lang('checkout.sum')</th>
                                <th class="right"><nobr>{{ number_format($row['transactions']['sum'], 0, '.', ' ') }} Ft</nobr></th>
                            </tr>
                        </tbody></table>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection