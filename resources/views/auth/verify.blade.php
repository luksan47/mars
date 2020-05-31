<!-- is this page even shown? -->

@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('Verify Your Email Address')</div>
                @if (session('resent'))
                <blockquote class="error">@lang('A fresh verification link has been sent to your email address.')</blockquote>
                @endif
                <blockquote>@lang('Before proceeding, please check your email for a verification link.')</blockquote>
                <p>@lang('If you did not receive the email'),
                    <a href="{{ route('verification.resend') }}"
                        onclick="event.preventDefault(); document.getElementById('resend').submit();">@lang('click here to request another')</a>
                    <form id="resend" action="{{ route('verification.resend') }}" method="POST" style="display: none;"> @csrf</form>
                </p>
            </div>
        </div>
    </div>
</div>
