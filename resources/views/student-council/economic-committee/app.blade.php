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
                @can('handleAny', \App\Models\Checkout::class)
                <div class="row">
                    <div class="col s12 m12 l6 xl6" style="margin-bottom:5px">
                        <a href="{{ route('kktnetreg') }}" class="btn waves-effect" style="width:100%">
                            @lang('checkout.pay_kktnetreg')</a>
                    </div>
                    <div class="col s12 m12 l6 xl6" style="margin-bottom:5px">
                        <a href="{{ route('economic_committee.transaction') }}" class="btn waves-effect" style="width:100%">
                            @lang('checkout.other_transaction')</a>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
    @foreach($data as $row)
    @php
    $semester = $row['semester'];
    @endphp
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $semester->tag().' ('.$semester->getStartDate()->format('Y.m.d').'-'.$semester->getEndDate()->format('Y.m.d').')'}}</span>
                <div class="row">
                    <div class="col s12">
                        <table><tbody>
                            <tr><th colspan="3">@lang('checkout.incomes')</th></tr>
                            <tr>
                                <td>@lang('checkout.kkt') - @lang('checkout.kkt_long')</td>
                                <td>
                                    @can('administrate', \App\Models\Checkout::studentsCouncil())
                                    <a href="{{ route('kktnetreg') }}" class="btn waves-effect">
                                        @lang('checkout.details')</a>
                                    @endcan
                                </td>
                                <td class="right"><nobr>{{ number_format($row['transactions']['kkt'], 0, '.', ' ') }} Ft</nobr></td>
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
                <div class="row">
                    <div class="col s12">
                        <table class="centered" style="display: block;overflow-x:auto;">
                            <thead>
                                <tr>
                                    <th>@lang('checkout.workshop_balances')</th>
                                    <th>@lang('general.members')@if($semester->isCurrent())*@endif</th>
                                    <th>
                                        @lang('checkout.allocated_balance')
                                        @if($semester->isCurrent())
                                        @can('administrate', \App\Models\Checkout::studentsCouncil())
                                        <a href="{{ route('economic_committee.workshop_balance') }}" class="btn-floating btn-small grey waves-effect">
                                            <i class="material-icons">refresh</i>
                                        </a>
                                        @endif
                                        @endcan
                                    </th>
                                    <th>@lang('checkout.used_balance')</th>
                                    <th>@lang('checkout.remaining_balance')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($row['workshop_balances'] as $workshop_balance)</th>
                                <tr>
                                    <td>{{ $workshop_balance->workshop->name }}</td>
                                    <td>
                                        @php
                                        $workshop = $workshop_balance->workshop;
                                        $payed_members = $workshop->membersPayedKKTNetregInSemester($semester);
                                        $payed_residents = $payed_members->filter(function($user, $key){ return $user->isResident();})->count();
                                        $payed_externs = $payed_members->filter(function($user, $key){ return $user->isExtern();})->count();
                                        $not_payed = $workshop->users->filter(function ($user, $key) use ($semester) {
                                            return ($user->hasToPayKKTNetregInSemester($semester));})->count();
                                        @endphp
                                        {{ $payed_residents }} / {{ $payed_externs}} (+{{ $not_payed }})
                                    </td>
                                    <td>{{ $workshop_balance->allocated_balance }}</td>
                                    <td>{{ $workshop_balance->used_balance }}</td>
                                    <td>{{ $workshop_balance->allocated_balance - $workshop_balance->used_balance }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($semester->isCurrent())
                        <blockquote>*@lang('checkout.workshop_balance_descr', ['kkt' => config('custom.kkt')])</blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
