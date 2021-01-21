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
                            <div class="input-field col s12 m6 l6">
                                <input id="comment" name="comment" type="text" required>
                                <label for="comment">@lang('checkout.description')</label>
                                @error('comment')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input id="amount" name="amount" type="number" required>
                                <label for="amount">@lang('checkout.amount')</label>
                                @error('amount')
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
</div>
@endsection
