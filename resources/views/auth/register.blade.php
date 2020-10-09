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
                    <blockquote>
                        @if($user_type == \App\Models\Role::COLLEGIST)
                        <a href="{{ route('register.guest') }}">
                            @lang('registration.collegist_to_tenant')</a>
                        @else
                        <a href="{{ route('register') }}">
                            @lang('registration.tenant_to_collegist')</a>
                        @endif
                    </blockquote>
                    <div class="divider"></div>
                    <div class="section">
                        @include("auth.register.basic")
                        <input type="text" name="user_type" id="user_type" value="{{ $user_type }}" readonly hidden>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        <div class="card-title">@lang('info.user_data')</div>
                        @include("auth.register.personal")
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                    <div class="card-title">@lang('info.contact')</div>
                        @include("auth.register.contact")
                    </div>
                    @if($user_type == \App\Models\Role::COLLEGIST)
                    <div class="divider"></div>
                    <div class="section">
                        <div class="card-title">@lang('info.information_of_studies')</div>
                        @include("auth.register.information_of_studies")
                    </div>
                    @endif
                    <div class="divider"></div>
                    <div class="section">
                        <div class="row">
                            <div class="col s12 l8">
                                <p><label>
                                    <input type="checkbox" name="gdpr" id="qdpr" value="qdpr" required
                                        class="filled-in checkbox-color" />
                                    <span>@lang('auth.i_agree_to') <a href="{{ route('privacy_policy') }}"
                                            target="_blank">@lang('auth.privacy_policy')</a></span>
                                </label></p>
                            </div>
                            <div class="col s12 l4">
                                <p><button class="btn waves-effect right"
                                    type="submit">@lang('general.register')
                                </button></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
