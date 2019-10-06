@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('internet.internet')</div>

                <div class="card-body">
                    @if(true)
                        <div class="alert alert-success">
                            <p>@lang('internet.internet_is_active')</p>
                            <p>@lang('internet.expiration_date'): {{ "yes" }}</p>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <p>@lang('internet.internet_in_not_active')</p>
                        </div>
					@endif
					<div class="alert alert-info">
						<strong>@lang('general.note'):</strong> @lang('internet.internet_registartion_description')
					</div>
                    @include("internet.activate")
                    @include("internet.time")
                    @include("internet.mac")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
