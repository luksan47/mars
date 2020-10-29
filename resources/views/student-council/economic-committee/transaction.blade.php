@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="{{ route('economic_committee') }}" class="breadcrumb" style="cursor: pointer">@lang('role.economic-committee')</a>
<a href="#!" class="breadcrumb">@lang('checkout.new_transaction')</a>
@endsection
@section('student_council_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('checkout.pay')</span>
                <blockquote>@lang('checkout.add_transaction_descr')</blockquote>
                <form method="POST" action="{{ route('economic_committee.transaction.add') }}">
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12 m4 l4">
                                <input id="comment" name="comment" type="text" required>
                                <label for="comment">@lang('checkout.description')</label>
                                @error('comment')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="amount" name="amount" type="number" required>
                                <label for="amount">@lang('checkout.amount')</label>
                                @error('amount')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="password" name="password" type="password" required>
                                <label for="password">@lang('checkout.password')</label>
                                @error('password')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-floating btn-large waves-effect right"><i class="large material-icons">send</i></button>
                </form>
            </div>
        </div>

        @foreach($semesters as $semester)
        @php
            $transactions = $semester->transactions;
        @endphp
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">{{ $semester->tag }}</span>
                        <table><tbody>
                            <tr>
                                <td>@lang('checkout.date')</td>
                                <td>@lang('checkout.payed_by')</td>
                                <td>@lang('checkout.collected_by')</td>
                                <td>@lang('checkout.details')</td>
                                <td>@lang('checkout.amount')</td>
                                <td>@lang('checkout.in_checkout')</td>
                            </tr>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>
                                            @if($transaction->payer)
                                                {{ $transaction->payer->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->receiver)
                                                {{ $transaction->receiver->name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $transaction->comment ?? $transaction->type->name }}</td>
                                        <td>{{ $transaction->amount }} Ft</td>
                                        <td>{{ $transaction->moved_to_checkout ?? '-'}}
                                    </tr>
                                @endforeach
                        </tbody></table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection