@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('role.economic-committee')</a>
<a href="#!" class="breadcrumb">@lang('checkout.kktnetreg')</a>
@endsection
@section('student_council_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.pay')</span>
                <form method="POST" action="{{ route('kktnetreg.pay') }}">
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12 m12 l4">
                                @include("utils.select", ['elements' => $users, 'element_id' => 'user_id'])
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="kkt" name="kkt" type="number" required min="0"
                                    value="{{ config('custom.kkt') }}">
                                <label for="kkt">@lang('checkout.kkt')</label>
                                @error('kkt')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="netreg" name="netreg" type="number" required min="0"
                                    value="{{ config('custom.netreg') }}">
                                <label for="netreg">@lang('checkout.netreg')</label>
                                @error('netreg')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-floating btn-large waves-effect right"><i class="large material-icons">send</i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col s12 m6 push-m6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.gathered_transactions')</span>
                <div class="row">
                    <div class="col s12">
                    <table><tbody>
                        @foreach($my_transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->payer->name }}</td>
                            @if(in_array($transaction->type->name, ['NETREG', 'KKT']))
                            <td>{{ $transaction->type->name }}</td>
                            @else
                            <td>{{ $transaction->comment ?? ''}}</td>
                            @endif
                            <td>{{ $transaction->amount }} Ft</td>
                        </tr>
                        @endforeach
                    </tbody></table>
                    </div>
                </div>
                <form method="POST" action="{{ route('kktnetreg.to_checkout') }}">
                    @csrf
                    <div class="row">
                        <div class="col s8">
                            <b>@lang('checkout.sum')</b>
                        </div>
                        <div class="col s4">
                            <b>{{ $sum_my_transactions }} Ft</b>
                        </div>
                        <div class="col s8">
                            <div class="input-field">
                                <input id="checkout_pwd" name="checkout_pwd" class="validate @error('checkout_pwd') invalid @enderror" required>
                                <label for="checkout_pwd">@lang('checkout.password')</label>
                                @error('checkout_pwd')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col s4">
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
    </div>
    <div class="col s12 m6 pull-m6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.users_have_to_pay')</span>
                <table><tbody>
                    @foreach($users as $user)
                    @if($user->haveToPayKKTNetreg())
                    <tr><td>{{ $user->name }}</td></tr>
                    @endif
                    @endforeach
                </tbody></table>
            </div>
        </div>
    </div>              
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('print.history')</span>
                <table><tbody>
                    <tr>
                        <td>@lang('general.semester')<td>
                        <td>@lang('checkout.date')</td>
                        <td>@lang('checkout.payed_by')</td>
                        <td>@lang('checkout.collected_by')</td>
                        <td>@lang('checkout.details')</td>
                        <td>@lang('checkout.amount')</td>
                        <td>@lang('checkout.in_checkout')</td>                           
                    </tr>
                    @foreach($all_transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->semester->tag()}}<td>
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->payer->name }}</td>
                        <td>{{ $transaction->receiver->name }}</td>
                        @if($transaction->type)
                        <td>{{ $transaction->type->name }}</td>
                        @else
                        <td>{{ $transaction->comment ?? ''}}</td>
                        @endif
                        <td>{{ $transaction->amount }} Ft</td>
                        <td>{{ $transaction->moved_to_checkout ?? '-'}}
                    </tr>
                    @endforeach
                </tbody></table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection