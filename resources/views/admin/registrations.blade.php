@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('admin.handle_registrations')</div>
                <div class="card-body">
                    @foreach ($users as $user)
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-md-9">
                                        {{ $user->name }}
                                </div>
                                <div class="col-md-3">
                                    <form class="d-inline" method="POST" action="{{ route('admin.registrations.show') }}">
                                        @csrf
                                        <input type="number" name="user_id" value="{{ $user->id }}" hidden>
                                        <button type="submit" class="btn btn-primary">{{ __('admin.show') }}</button>
                                    </form>
                                    <form class="d-inline" method="POST" action="{{ route('admin.registrations.accept') }}">
                                        @csrf
                                        <input type="number" name="user_id" value="{{ $user->id }}" hidden>
                                        <button type="submit" class="btn btn-success">{{ __('admin.accept') }}</button>
                                    </form>
                                    <form class="d-inline" method="POST" action="{{ route('admin.registrations.reject') }}">
                                        @csrf
                                        <input type="number" name="user_id" value="{{ $user->id }}" hidden>
                                        <button type="submit" class="btn btn-danger">{{ __('admin.reject') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
