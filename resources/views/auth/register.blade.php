@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12 l8 xl6 offset-l2 offset-xl3">
        <div class="card">
            <div class="card-image">
                <img src="/img/EC_building.jpg">
                <span class="card-title">@lang('general.register')</span>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card-content">
                    @foreach ($errors->all() as $error)
                        <blockquote class="error">{{ $error }}</blockquote>
                    @endforeach
                    {{--basic information--}}
                    <div class="section">
                        <div class="row">
                            <x-input.text id="email"      type="email"    locale="registration" required autocomplete="email" autofocus/>
                            <x-input.text id="password"   locale="registration" type="password" required autocomplete="new-password"/>
                            <x-input.text id="confirmpwd" locale="registration" name="password_confirmation" type="password" required autocomplete="new-password"/>
                        </div>
                        <input type="text" name="user_type" id="user_type" value="{{ $user_type }}" readonly hidden>
                    </div>
                    <div class="divider"></div>
                    {{--personal information--}}
                    <div class="section">
                        <div class="card-title">@lang('user.user_data')</div>
                        <div class="row">
                            <x-input.text id='name' required autocomplete='name' locale='user'/>
                            <x-input.text l=6 id='place_of_birth' required locale='user'/>
                            <x-input.datepicker l=6 id='date_of_birth' required locale='user'/>
                            <x-input.text id='mothers_name' required locale='user'/>
                            <x-input.text id='phone_number' type='tel' required
                                pattern="[+][0-9]{1,4}[-\s()0-9]*" minlength="8" maxlength="18"
                                locale='user' helper='+36 (20) 123-4567'/>
                            @if ($user_type == \App\Models\Role::TENANT)
                              <x-input.datepicker id='tenant_until' required locale='user'/>
                            @endif
                        </div>
                    </div>
                    <div class="divider"></div>
                    {{--contact information--}}
                    <div class="section">
                    <div class="card-title">@lang('user.contact')</div>
                    <div class="row">
                        <x-input.select id="country" :elements="$countries" default="Hungary" locale="user"/>
                        <x-input.text l=6 id='county'        locale='user' required/>
                        <x-input.text l=6 id='zip_code'      locale='user' type='number' required/>
                        <x-input.text id='city'              locale='user' required/>
                        <x-input.text id='street_and_number' locale='user' required/>
                    </div>
                    <div class="divider"></div>
                    @if($user_type == \App\Models\Role::COLLEGIST)
                        <blockquote>@lang('registration.information')</blockquote>
                    @endif
                    <div class="section">
                        <div class="row">
                            <div class="col s12 l8">

                                <p><label>
                                    <input type="checkbox" name="gdpr" id="qdpr" value="qdpr" required
                                        class="filled-in checkbox-color" />
                                    <span>@lang('auth.i_agree_to') <a href="{{ route('privacy_policy') }}"
                                            target="_blank">@lang('auth.privacy_policy').</a></span>
                                </label></p>
                            </div>
                            <x-input.button l=4 class='right' text='general.register'/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
