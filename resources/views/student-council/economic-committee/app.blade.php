@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('role.economic-committee')</a>
@endsection
@section('student_council_module') active @endsection

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
                @can('addKKTNetreg', \App\Models\Checkout::class)
                    <a href="{{ route('kktnetreg') }}" class="btn waves-effect">
                        @lang('checkout.kktnetreg')</a>
                @endcan
            </div>
        </div>
    </div>
    <div class="col s12">
        @include('utils.checkout.add-transaction')
    </div>
    @foreach($semesters as $semester)
    @php
        $transactions = $semester->transactions;
    @endphp
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $semester->tag }}</span>
                <div class="row">
                    <div class="col s12">
                        <table><tbody>
                            <tr><th colspan="3">@lang('checkout.incomes')</th></tr>
                            @include('utils.checkout.sum', ['paymentType' => \App\Models\PaymentType::kkt()])
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
                <div class="row">
                    <div class="col s12">
                        <table class="highlight responsive-table centered" style="display: block;overflow-x:auto;">
                            <thead>
                                <tr>
                                    <th class="valign-wrapper">@lang('checkout.workshop_balances')</th>
                                    <th>@lang('general.members')@if($semester->isCurrent())*@endif</th>
                                    <th>
                                        @lang('checkout.allocated_balance')
                                        @if($semester->isCurrent())
                                            @can('administrate', \App\Models\Checkout::studentsCouncil())
                                            <a href="{{ route('economic_committee.workshop_balance') }}" class="btn-floating btn-small grey waves-effect">
                                                <i class="material-icons">refresh</i>
                                            </a>
                                            @endcan
                                        @endif
                                    </th>
                                    <th>@lang('checkout.used_balance')</th>
                                    <th>@lang('checkout.remaining_balance')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semester->workshopBalances as $workshop_balance)
                                <tr>
                                    <td class="valign-wrapper">{{ $workshop_balance->workshop->name }} </td>
                                    <td>{{ $workshop_balance->resident . ' - ' . $workshop_balance->extern . ' (+' . $workshop_balance->not_yet_paid . ')' }}</td>
                                    <td>{{ $workshop_balance->allocated_balance }}</td>
                                    <td>{{ $workshop_balance->used_balance }}</td>
                                    <td>{{ $workshop_balance->allocated_balance - $workshop_balance->used_balance }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($semester->isCurrent())
                        <blockquote>*@lang('checkout.workshop_balance_descr', [
                            'kkt' => config('custom.kkt'),
                            'resident' => config('custom.workshop_balance_resident'),
                            'extern' => config('custom.workshop_balance_extern')
                        ])</blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
