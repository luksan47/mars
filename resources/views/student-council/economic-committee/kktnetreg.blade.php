@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="{{ route('economic_committee') }}" class="breadcrumb" style="cursor: pointer">@lang('role.economic-committee')</a>
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
                                @include("utils.select", [
                                    'elements' => $users->filter(function ($value, $key) {
                                            return true;// $value->haveToPayKKTNetreg(); //all user will be better for now TODO change this later
                                        }), 
                                    'element_id' => 'user_id',
                                    'required' => true])
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
    <div class="col s12 xl6 push-xl6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.gathered_transactions')</span>
                <div class="row">
                    <div class="col s12">
                    <table><tbody>
                        @foreach($my_transactions as $transaction)
                        <tr>
                            @if($transaction->payer)
                            <td>{{ $transaction->payer->name }}</td>
                            @else <td></td> @endif
                            @if(in_array($transaction->type->name, ['NETREG', 'KKT']))
                            <td>{{ $transaction->type->name }}</td>
                            @else
                            <td>{{ $transaction->comment ?? ''}}</td>
                            @endif
                            <td>{{ $transaction->amount }} Ft</td>
                            <td>
                                <a href="{{ route('economic_committee.transaction.delete', ['transaction' => $transaction->id]) }}" 
                                    class="btn-floating waves-effect right red">
                                    <i class="material-icons">delete</i></a>
                            </td>
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
    </div>
    <div class="col s12 xl6 pull-xl6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.users_have_to_pay') ({{ $current_semester }}) </span>
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
    {{-- Temporary solution while generating workshop balances does not work (#382) --}}
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.payed_kkt') ({{\App\Models\Semester::current()->tag()}})</span>
                <table><tbody>
                    <tr>
                        <th>@lang('print.user')</th>
                        <th>@lang('user.workshop')</th>
                        <th>@lang('checkout.amount')</th>                          
                    </tr>
                    @foreach($all_transactions as $transaction)
                    @if($transaction->semester == \App\Models\Semester::current())
                    @if(in_array($transaction->type->name, ['KKT']))
                    <tr>
                        <td>{{ $transaction->payer->name}}</td>
                        <td>
                            @foreach($transaction->payer->workshops as $workshop)
                            {{ $workshop->name }}<br>
                            @endforeach
                        </td>
                        <td>{{ $transaction->amount }}</td>
                    </tr>
                    @endif
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
                        @if($transaction->payer)
                        <td>{{ $transaction->payer->name }}</td>
                        @else <td></td> @endif
                        @if($transaction->receiver)
                        <td>{{ $transaction->receiver->name }}</td>
                        @else <td></td> @endif
                        @if(in_array($transaction->type->name, ['NETREG', 'KKT']))
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
