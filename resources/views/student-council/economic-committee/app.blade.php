@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('role.economic-committee')</a>
@endsection
@section('student_council_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <p>
        <a href="{{ route('kktnetreg') }}" class="btn btn-large waves-effect">
            @lang('checkout.pay_kktnetreg')</a>
        <a href="{{ route('economic_committee.transaction') }}" class="btn btn-large waves-effect">
            @lang('checkout.other_transaction')</a>
        </p>
    </div>
    @foreach($transactions as $semester => $data)
    <div class="col s12">
        <div class="card">
            <div class="card-content">  
                <span class="card-title">{{ $semester }}</span>
                <table><tbody>
                    <tr><th colspan="3">@lang('checkout.incomes')</th></tr>
                    <tr>
                        <td>@lang('checkout.kkt') - @lang('checkout.kkt_long')</td>
                        <td><a href="{{ route('kktnetreg') }}" class="btn-flat waves-effect">
                           @lang('checkout.details')</a></td>
                        <td class="right">{{ $data['kkt'] }} Ft</td>
                    </tr>
                    @foreach($data['income'] as $transaction)
                    <tr>
                        <td>{{ $transaction->comment }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td class="right">{{ $transaction->amount }}</td>
                    </tr>
                    @endforeach
                    <tr><th colspan="3">@lang('checkout.expenses')</th></tr>
                    @foreach($data['expense'] as $transaction)
                    <tr>
                        <td>{{ $transaction->comment }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td class="right">{{ $transaction->amount }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">@lang('checkout.sum')</th>
                        <th class="right">{{ $data['sum'] }} Ft</th>
                    </tr>
                </tbody></table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection