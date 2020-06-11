@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('info.user_data')</div>
                <div class="row">
                    <table>
                        <tbody>
                            <tr>
                                <td>@lang('info.name')</td>
                                <td colspan="2">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <form method="POST" action="{{ route('userdata.update_email') }}">
                                    @csrf
                                    <td>@lang('registration.email')</td>
                                    <td>
                                        <input id="email" type="email" name="email"
                                            value="{{ old('email', $user->email) }}" required autocomplete="email">
                                        @error('email')
                                        <blockquote class="error">
                                            {{ $message }}
                                        </blockquote>
                                        @enderror
                                    </td>
                                    <td>
                                        <button class="waves-effect  btn-flat right"
                                            type="submit">@lang('general.change_email')</button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <td>@lang('info.neptun')</td>
                                <td colspan="2">{{ $neptun }}</td>
                            </tr>
                            <tr>
                                <td>@lang('info.phone_number')</td>
                                <td colspan="2">{{ $phone_number }}</td>
                            </tr>
                            <tr>
                                <td>@lang('info.faculty')</td>
                                <td colspan="2">
                                    <ul>
                                        @foreach ($faculties as $faculty)
                                        <li>{{$faculty->name}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('info.workshop')</td>
                                <td colspan="2">
                                    <ul>
                                        @foreach ($workshops as $workshop)
                                        <li>{{$workshop->name}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-action">
                <div class="row">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn waves-effect right " type="submit">@lang('general.logout')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('general.change_password')</div>
                <form method="POST" action="{{ route('userdata.update_password') }}">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="old_password" type="password" name="old_password" required
                                autocomplete="password">
                            <label for="old_password">@lang('registration.old_password')</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="new_password" type="password" name="new_password" required
                                >
                            <label for="new_password">@lang('registration.new_password')</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                required>
                            <label for="new_password_confirmation">@lang('registration.confirmpwd')</label>
                        </div>
                        <div class="input-field col s4">
                            <button class="btn waves-effect right"
                                type="submit">@lang('general.change_password')</button>
                        </div>
                    </div>
                    @error('old_password')
                    <blockquote class="error">
                        {{ $message }}
                    </blockquote>
                    @enderror
                    @error('new_password')
                    <blockquote class="error">
                        {{ $message }}
                    </blockquote>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
@endsection