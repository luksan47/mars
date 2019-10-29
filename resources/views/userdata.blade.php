@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('general.user_data')</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('userdata.update_email') }}">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">@lang('registration.email')</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ $user->email }}" required autocomplete="email" autofocus>
                                            
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                            @lang('general.change_email')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('userdata.update_password') }}">
                            @csrf

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="old_password" class="col-md-4 col-form-label text-md-right">@lang('registration.old_password')</label>

                                        <div class="col-md-6">
                                            <input id="old_password" type="password" class="form-control @error('password') is-invalid @enderror" name="old_password" required autocomplete="password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">@lang('registration.password')</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('registration.confirmpwd')</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                            @lang('general.change_password')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection