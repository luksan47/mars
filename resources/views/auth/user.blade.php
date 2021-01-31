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
                        <div class="input-field col s12">
                            <input id="old_password" type="password" name="old_password" required
                                autocomplete="password" class="validate @error('old_password') invalid @enderror">
                            <label for="old_password">@lang('registration.old_password')</label>
                            @error('old_password')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s6">
                            <input id="new_password" type="password" name="new_password" required 
                                class="validate @error('new_password') invalid @enderror">
                            <label for="new_password">@lang('registration.new_password')</label>
                            @error('new_password')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s6">
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                required class="validate @error('new_password') invalid @enderror">
                            <label for="new_password_confirmation">@lang('registration.confirmpwd')</label>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row" style="margin-bottom: 0">
                        <button class="btn waves-effect right" type="submit">@lang('general.change_password')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
