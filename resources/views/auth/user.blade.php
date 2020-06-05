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
                            <td>{{ $user->name }}</td>
                          </tr>
                          <tr>
                            <td>@lang('info.neptun')</td>
                            <td>{{ $user->neptun }}</td>
                          </tr>
                          <tr>
                            <td>@lang('info.phone_number')</td>
                            <td>{{ $user->phone_number }}</td>
                          </tr>
                          <tr>
                            <td>@lang('info.faculty')</td>
                            <td>
                                <ul>
                                    @foreach ($faculties as $faculty)
                                        <li>{{$faculty->name}}</li>
                                    @endforeach
                                </ul>
                            </td>
                          </tr>
                          <tr>
                            <td>@lang('info.workshop')</td>
                            <td>
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
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="row">
                        <button class="btn waves-effect right " type="submit">@lang('general.logout')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('general.change_email')</div>
                <form method="POST" action="{{ route('userdata.update_email') }}">
                    @csrf
                    <div class="row">
                        <div class="input-field col s8">
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="{{ $user->email }}" required autocomplete="email" autofocus>
                            <label for="email">@lang('registration.email')</label>
                            @error('email')
                            <blockquote class="error">
                                {{ $message }}
                            </blockquote>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <button class="btn waves-effect right" type="submit">@lang('general.change_email')</button>
                        </div>
                    </div>
                </form>
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
                                autocomplete="new-password">
                            <label for="new_password">@lang('registration.new_password')</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="password_confirm" type="password" name="password_confirm" required
                                autocomplete="new-password">
                            <label for="password_confirm">@lang('registration.confirmpwd')</label>
                        </div>
                        <div class="input-field col s4">
                            <button class="btn waves-effect right"
                                type="submit">@lang('general.change_password')</button>
                        </div>
                    </div>
                    @error('password' or 'new_password' or 'old_password')
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