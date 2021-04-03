@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('user.user_data')</div>
                <blockquote>@lang('user.change_outdated_data')</blockquote>
                @include('user.roles_status_table', ['user' => $user])
            </div>
            {{-- Logout --}}
            <div class="card-action">
                <div class="row" style="margin-bottom: 0">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn waves-effect right " type="submit">@lang('general.logout')</button>
                    </form>
                </div>
            </div>
        </div>
        {{-- Personal information --}}
        @include('user.personal-information', ['user' => $user, 'modifiable' => true])
        {{-- Educational information --}}
        @include('user.educational-information', ['user' => $user])

    {{-- Change password  --}}
        <div class="card">
            <form method="POST" action="{{ route('secretariat.user.update_password') }}">
                @csrf
                <div class="card-content">
                    <div class="card-title">@lang('general.change_password')</div>
                    <div class="row" style="margin-bottom: 0">
                        <x-input.text id='old_password' locale="registration" type='password' required autocomplete="password"/>
                        <x-input.text s=6 id='new_password' locale="registration" type='password' required autocomplete="new-password"/>
                        <x-input.text s=6 id='confirmpwd' locale="registration" name="new_password_confirmation" type='password' required autocomplete="new-password"/>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row" style="margin-bottom: 0">
                        <x-input.button only_input class="right" text="general.change_password"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
