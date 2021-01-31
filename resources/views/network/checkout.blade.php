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
        @can('administrate', $checkout)
            <div class="row">
                <div class="col s12">
                    @include('utils.checkout.all-gathered-transactions')
                </div>
                <div class="col s12 xl6">
                    @include('utils.checkout.add-transaction')
                </div>
                <div class="col s12 xl6">
                    @include('utils.checkout.gathered-transactions')
                </div>
            </div>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col s12">
        @foreach ($semesters as $semester)
        @php
            $transactions = $semester->transactions;
        @endphp
            <div class="card">
                <div class="card-content">
                    <span class="card-title">{{ $semester->tag }}</span>
                    <div class="row">
                        <div class="col s12">
                            <table><tbody>
                                <tr><th colspan="3">@lang('checkout.incomes')</th></tr>
                                @include('utils.checkout.sum', ['paymentType' => \App\Models\PaymentType::print()])
                                @include('utils.checkout.sum', ['paymentType' => \App\Models\PaymentType::netreg()])
                                @include('utils.checkout.list', ['paymentType' => \App\Models\PaymentType::income()])
                                <tr><th colspan="3">@lang('checkout.expenses')</th></tr>
                                @include('utils.checkout.list', ['paymentType' => \App\Models\PaymentType::expense()])
                                <tr>
                                    <th colspan="2">@lang('checkout.sum')</th>
                                    <th class="right"><nobr>{{ number_format($semester->transactions->sum('amount'), 0, '.', ' ') }} Ft</nobr></th>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
