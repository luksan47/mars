@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @include("auth.register.basic")

                        <input type="text" name="user_type" id="user_type" value="{{ $user_type }}" readonly hidden>
						<div class="card">
							<div class="card-header">@lang('info.user_data')</div>
							<div class="card-body">
                                @include("auth.register.personal")
                            </div>
                        </div>

						<div class="card">
							<div class="card-header">@lang('info.contact')</div>
							<div class="card-body">
                                @include("auth.register.contact")
                            </div>
                        </div>
                        
                        @if($user_type == \App\Role::COLLEGIST)
                            <div class="card">
                                <div class="card-header">@lang('info.information_of_studies')</div>
                                <div class="card-body">
                                    @include("auth.register.information_of_studies")
                                </div>
                            </div>
                        @endif
                        <div class="checkbox">
                            <label><input type="checkbox" name="gdpr" value="gdpr" required>
                                @lang('auth.i_agree_to') <a href="{{ route('privacy_policy') }}" target="_blank">@lang('auth.privacy_policy')</a>
                            </label>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Datepicker script -->
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
@endsection
