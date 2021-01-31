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
                            <blockquote>@lang('checkout.pay_kkt_descr')</blockquote>
                            <div class="input-field col s12 m12 l4">
                                @include("utils.select", [
                                    'elements' => $users_not_payed,
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
    <div class="col s12">
        @include('utils.checkout.all-gathered-transactions')
    </div>
    <div class="col s12 xl6 push-xl6">
        @include('utils.checkout.gathered-transactions')
    </div>
    <div class="col s12 xl6 pull-xl6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.users_have_to_pay') ({{ \App\Models\Semester::current()->tag }}) </span>
                <table><tbody>
                    @foreach($users_not_payed as $user)
                      <tr><td>{{ $user->name }}</td></tr>
                    @endforeach
                </tbody></table>
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.payed_kkt') ({{\App\Models\Semester::current()->tag}})</span>
                <table><tbody>
                    <tr>
                        <th>@lang('print.user')</th>
                        <th>@lang('user.workshop')</th>
                        <th>@lang('checkout.amount')</th>
                    </tr>
                    @foreach($transactions as $transaction)
                        @if($transaction->type->name == \App\Models\PaymentType::KKT)
                            <tr>
                                <td>{{ $transaction->payer->name }}</td>
                                <td>
                                    @include('user.workshop_tags', ['user' => $transaction->payer])
                                </td>
                                <td>{{ $transaction->amount }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody></table>
            </div>
        </div>
    </div>
</div>
@endsection
