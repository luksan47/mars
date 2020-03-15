@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-image">
                <img src="/img/EC_building.jpg">
                <span class="card-title">@lang('general.register')</span>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card-content">
                    <blockquote>
                        @if($user_type == \App\Role::COLLEGIST)
                        <a href="{{ route('register.guest') }}" class="secondary-text-color">
                            @lang('registration.collegist_to_tenant')</a>
                        @else
                        <a href="{{ route('register') }}" class="secondary-text-color">
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
                    <div class="divider"></div>
                    <div class="section">
                        @if($user_type == \App\Role::COLLEGIST)
                        <div class="card-title">@lang('info.information_of_studies')</div>
                        @include("auth.register.information_of_studies")
                        @endif
                    </div>
                    <div class="divider"></div>
                    @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                            </ul>
                    @endif
                    <div class="row">
                        <div class="col s8">
                            <label>
                                <input type="checkbox" name="gdpr" id="qdpr" value="qdpr" required
                                    class="filled-in checkbox-color" />
                                <span>@lang('auth.i_agree_to') <a href="{{ route('privacy_policy') }}"
                                        target="_blank">@lang('auth.privacy_policy')</a></span>
                            </label>
                        </div>
                        <div class="col s4">
                            <button class="btn waves-effect secondary-color right"
                                type="submit">@lang('general.register')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Datepicker script
<script type="text/javascript">
	$(function(){
		$('.date').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			clearBtn: true,
			weekStart: 1,
			startView: "century"
		})
	});
</script>
-->
    @endsection