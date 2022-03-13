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
                            <x-input.select l=4 :elements="$users_not_payed" id="user_id" text="general.user" :formatter="function($user) { return $user->uniqueName; }" />
                            <x-input.text  m=6 l=4 id="kkt" type="number" required min="0" :value="config('custom.kkt')" />
                            <x-input.text  m=6 l=4 id="netreg" type="number" required min="0" :value="config('custom.netreg')" />
                        </div>
                    </div>
                    <x-input.button floating class="btn-large right" icon="send" />
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
{{-- TODO
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
--}}
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
                        @if($transaction->type->name == \App\Models\PaymentType::KKT && $transaction->semester_id == \App\Models\Semester::current()->id)
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
