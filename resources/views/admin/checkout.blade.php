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
                <span class="card-title">@lang('admin.netreg')</span>
                <form method="POST" action="{{ route('admin.netreg.pay') }}">
                    @csrf
                    <div class="input-field col s12 m12 l5">
                        @include("utils.select", ['elements' => $users, 'element_id' => 'user_id'])
                    </div>
                    <div class="input-field col s12 m12 l5">
                        <input id="amount" name="amount" type="number" class="validate @error('number') invalid @enderror" required
                            value="{{ config('custom.netreg') }}">
                        <label for="amount">@lang('print.amount')</label>
                        @error('amount')
                        <span class="helper-text" data-error="{{ $message }}"></span>
                        @enderror
                    </div>
                    <div class="input-field col s12 m12 l2">
                        <button type="submit" class="btn waves-effect right">@lang('print.add')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection