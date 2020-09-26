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
                    <b class="coli-text text-orange"> {{ $current_balance }} Ft</b>.<br>
                    @lang('checkout.current_balance_in_checkout'): 
                    <b class="coli-text text-orange"> {{ $current_balance_in_checkout }} Ft</b>.<br>
                </blockquote>
                @if(Auth::user()->hasRole(\App\Role::STUDENT_COUNCIL))
                <div class="row">
                    <div class="col s12 m12 l6 xl3" style="margin-bottom:5px">
                        <a href="{{ route('kktnetreg') }}" class="btn waves-effect" style="width:100%">
                            @lang('checkout.pay_kktnetreg')</a>
                    </div>
                    <div class="col s12 m12 l6 xl3" style="margin-bottom:5px">
                        <a href="#" class="btn waves-effect" disabled style="width:100%">
                            @lang('checkout.transaction_for_workshop')</a>
                    </div>
                    <div class="col s12 m12 l6 xl3" style="margin-bottom:5px">
                        <a href="{{ route('economic_committee.transaction') }}" class="btn waves-effect" style="width:100%">
                            @lang('checkout.other_transaction')</a>
                    </div>
                    <div class="col s12 m12 l6 xl3" style="margin-bottom:5px">
                        <a href="#" class="btn waves-effect" disabled style="width:100%">
                            @lang('checkout.receipts')</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @foreach($data as $semester => $row)
    <div class="col s12">
        <div class="card">
            <div class="card-content">  
                <span class="card-title">{{ $semester }}</span>
                <div class="row">
                    <div class="col s12">
                        <table><tbody>
                            <tr><th colspan="3">@lang('checkout.incomes')</th></tr>
                            <tr>
                                <td>@lang('checkout.kkt') - @lang('checkout.kkt_long')</td>
                                <td>
                                    @if(Auth::user()->hasRole(\App\Role::STUDENT_COUNCIL))
                                    <a href="{{ route('kktnetreg') }}" class="btn-flat waves-effect">
                                        @lang('checkout.details')</a></td>
                                    @endif
                                <td class="right">{{ $row['transactions']['kkt'] }} Ft</td>
                            </tr>
                            @foreach($row['transactions']['income'] as $transaction)
                            <tr>
                                <td>{{ $transaction->comment }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td class="right">{{ $transaction->amount }}</td>
                            </tr>
                            @endforeach
                            <tr><th colspan="3">@lang('checkout.expenses')</th></tr>
                            @foreach($row['transactions']['expense'] as $transaction)
                            <tr>
                                <td>{{ $transaction->comment }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                <td class="right">{{ $transaction->amount }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="2">@lang('checkout.sum')</th>
                                <th class="right">{{ $row['transactions']['sum'] }} Ft</th>
                            </tr>
                        </tbody></table>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <table class="responsive-table centered">
                        <thead>
                            <tr>
                                <th>@lang('checkout.workshop_balances')</th>
                                <th>@lang('general.members')*</th>
                                <th>
                                    @lang('checkout.allocated_balance')
                                    @if(Auth::user()->hasRole(\App\Role::STUDENT_COUNCIL))
                                    <a href="#" class="btn-floating btn-small grey waves-effect">
                                        <i class="material-icons">refresh</i>
                                    </a>
                                    @endif
                                </th>
                                <th>@lang('checkout.used_balance')</th>
                                <th>@lang('checkout.remaining_balance')</th>
                            @foreach($row['workshop_balances'] as $workshop => $workshop_balance)</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $workshop }}</td>
                                <td>
                                    {{ $workshop_balance['payed_member_num'] }} 
                                    @if($workshop_balance['remaining_members_num'] > 0)
                                    (+{{ $workshop_balance['remaining_members_num'] }}) 
                                    @endif
                                </td>
                                <td>{{ $workshop_balance['allocated_balance'] }}</td>
                                <td>{{ $workshop_balance['used_balance'] }}</td>
                                <td>{{ $workshop_balance['remaining_balance'] }}</td>
                            </tr>
                            @endforeach
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection