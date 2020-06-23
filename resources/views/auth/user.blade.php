@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('info.user_data')</div>
                <table>
                    <tbody>
                        <tr>
                            <th scope="row">@lang('info.name')</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        {{-- email --}}
                        <tr>
                            <th scope="row">@lang('registration.email')</th>
                            <td>
                                <form method="POST" action="{{ route('userdata.update_email') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="email" type="email" name="email" size="30" disabled style="margin:0"
                                            value="{{ old('email', $user->email) }}" required autocomplete="email"
                                            class="validate black-text">
                                    </div>
                                    <button id="email_send_btn" class="btn-floating right waves-effect waves-light hide"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="email_edit_btn" class="btn-floating right waves-effect waves-light"
                                        onclick="mail_editor()" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                    <script>
                                        function mail_editor(){
                                                document.getElementById('email').disabled=false;
                                                document.getElementById('email').value="";
                                                document.getElementById('email').focus();
                                                document.getElementById('email_edit_btn').classList.add('hide');
                                                document.getElementById('email_send_btn').classList.remove('hide');
                                            }
                                    </script>
                                </form>
                                @error('email')
                                <blockquote class="error">
                                    {{ $message }}
                                </blockquote>
                                @enderror
                            </td>
                        </tr>
                        {{-- Phone number --}}
                        @if($user->hasPersonalInformation())
                        <tr>
                            <th scope="row">@lang('info.phone_number')</th>
                            <td>
                                <form method="POST" action="{{ route('userdata.update_phone') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="phone_number" type="tel" name="phone_number" size="30" disabled
                                            style="margin:0" class="validate black-text"
                                            value="{{ old('phone_number', $user->personalInformation->phone_number ?? '') }}"
                                            pattern="[+][0-9]{1,4}\s[(][0-9]{1,4}[)]\s[-|0-9]*" minlength="16"
                                            maxlength="18" required>
                                        <span id="phone_format" class="helper-text hide">+36 (20) 123-4567</span>
                                    </div>
                                    <button id="phone_send_btn" class="btn-floating right waves-effect waves-light hide"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="phone_edit_btn" class="btn-floating right waves-effect waves-light"
                                        onclick="phone_editor()" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                    <script>
                                        function phone_editor(){
                                                document.getElementById('phone_number').disabled=false;
                                                document.getElementById('phone_number').value="+36 ";
                                                document.getElementById('phone_edit_btn').classList.add('hide');
                                                document.getElementById('phone_send_btn').classList.remove('hide');
                                                document.getElementById('phone_format').classList.remove('hide');
                                            }
                                    </script>
                                </form>
                                @error('phone_number')
                                <blockquote class="error">
                                    {{ $message }}
                                </blockquote>
                                @enderror
                            </td>
                        </tr>
                        @endif
                        {{-- Neptun code, faculties and workshops --}}
                        @if($user->hasEducationalInformation())
                        <tr>
                            <th scope="row">@lang('info.neptun')</th>
                            <td>{{ $user->educationalInformation->neptun ?? ''}}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('info.faculty')</th>
                            <td>
                                <ul>
                                    @foreach ($user->faculties as $faculty)
                                    <li>{{$faculty->name}}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('info.workshop')</th>
                            <td>
                                <ul>
                                    @foreach ($user->workshops as $workshop)
                                    <li>{{$workshop->name}}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @if($user->hasEducationalInformation())
                <blockquote>@lang('user.change_outdated_data')</blockquote>
                @endif
            </div>
            {{-- Logout --}}
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
    {{-- Change password  --}}
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
                            @error('old_password')
                            <blockquote class="error">
                                {{ $message }}
                            </blockquote>
                            @enderror
                        </div>
                        <div class="input-field col s6 xl4">
                            <input id="new_password" type="password" name="new_password" required>
                            <label for="new_password">@lang('registration.new_password')</label>
                        </div>
                        <div class="input-field col s6 xl4">
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                required>
                            <label for="new_password_confirmation">@lang('registration.confirmpwd')</label>
                        </div>
                        <div class="input-field col s12 xl4">
                            <button class="btn waves-effect right"
                                type="submit">@lang('general.change_password')</button>
                        </div>
                        @error('new_password')
                        <div class="col s12">
                            <blockquote class="error">
                                {{ $message }}
                            </blockquote>
                        </div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection