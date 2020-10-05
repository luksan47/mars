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
                    <div class="col s12 xl6 push-xl6">
                        <span class="card-title">@lang('checkout.print')</span>
                    </div>
                    <div class="col s12 xl6 pull-xl6">
                        <span class="card-title">@lang('checkout.pay')</span>
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