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
            </div>
        </div>
        @can('addPayment', \App\Models\Checkout::admin())
            <div class="row">
                <div class="col s12 xl6">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">@lang('checkout.new_transaction')</span>
                            <blockquote>@lang('checkout.add_transaction_descr')</blockquote>
                            <form method="POST" action="{{ route('admin.checkout.transaction.add') }}">
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
                                    <div class="col s12">
                                        <div class="input-field col s12">
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
                    </div>
                </div>
                <div class="col s12 xl6">
                    @include('utils.checkout.gathered-transactions')
                </div>
            </div>
        @endcan
    </div>
</div>

@foreach($transactions as $semester => $transaction)

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $semester }}</span>
                <div class="row">
                    <div class="col s12">
                        <table><tbody>
                            <tr><th colspan="3">@lang('checkout.incomes')</th></tr>
                            @include('utils.checkout.sum', ['paymentType' => \App\Models\PaymentType::PRINT])
                            @include('utils.checkout.sum', ['paymentType' => \App\Models\PaymentType::NETREG])
                            @include('utils.checkout.list', ['paymentType' => \App\Models\PaymentType::INCOME])
                            <tr><th colspan="3">@lang('checkout.expenses')</th></tr>
                            @include('utils.checkout.list', ['paymentType' => \App\Models\PaymentType::EXPENSE])
                            <tr>
                                <th colspan="2">@lang('checkout.sum')</th>
                                <th class="right"><nobr>{{ number_format($current_balance, 0, '.', ' ') }} Ft</nobr></th>
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