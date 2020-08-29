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
                                        <input id="email" type="email" name="email" size="30" autocomplete="email"
                                            @if(!($errors->has('email'))) disabled @endif 
                                            style="margin:0" value="{{ old('email', $user->email) }}" required 
                                            class="validate black-text @error('email') invalid @enderror">
                                        @error('email')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
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
                                        <input id="phone_number" type="tel" name="phone_number" size="30" 
                                            @if(!($errors->has('phone_number'))) disabled @endif 
                                            style="margin:0" class="validate black-text @error('phone_number') invalid @enderror"
                                            value="{{ old('phone_number', $user->personalInformation->phone_number ?? '') }}"
                                            pattern="[+][0-9]{1,4}\s[(][0-9]{1,4}[)]\s[-|0-9]*" minlength="16"
                                            maxlength="18" required>
                                        <span id="phone_format" class="helper-text hide">+36 (20) 123-4567</span>
                                        @error('phone_number')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
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
                            </td>
                        </tr>
                        @endif
                        {{-- Other personal information --}}
                        @if($user->hasPersonalInformation())
                            <tr>
                                <th scope="row">@lang('info.place_and_date_of_birth')</th>
                                <td>
                                    {{ $user->personalInformation->place_of_birth }},  {{ $user->personalInformation->date_of_birth }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('info.mothers_name')</th>
                                <td>
                                    {{ $user->personalInformation->mothers_name }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('info.address')</th>
                                <td>
                                    {{ $user->personalInformation->country }}, <small>{{ $user->personalInformation->county }}</small>
                                    <br>
                                    {{ $user->personalInformation->zip_code }} {{ $user->personalInformation->city }},
                                    <small>{{ $user->personalInformation->street_and_number }} </small>
                                </td>
                            </tr>
                        @endif
                        {{-- Other educational information --}}
                        @if($user->hasEducationalInformation())
                            <tr>
                                <th scope="row">@lang('info.high_school')</th>
                                <td>{{ $user->educationalInformation->high_school }}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('info.year_of_graduation')</th>
                                <td>{{ $user->educationalInformation->year_of_graduation }}</td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('info.year_of_acceptance')</th>
                                <td>{{ $user->educationalInformation->year_of_acceptance }}</td>
                            </tr>
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
                <div class="row" style="margin-bottom: 0">
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
            <form method="POST" action="{{ route('userdata.update_password') }}">
                @csrf
                <div class="card-content">
                    <div class="card-title">@lang('general.change_password')</div>
                    <div class="row" style="margin-bottom: 0">
                        <div class="input-field col s12">
                            <input id="old_password" type="password" name="old_password" required
                                autocomplete="password" class="validate @error('old_password') invalid @enderror">
                            <label for="old_password">@lang('registration.old_password')</label>
                            @error('old_password')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s6">
                            <input id="new_password" type="password" name="new_password" required 
                                class="validate @error('new_password') invalid @enderror">
                            <label for="new_password">@lang('registration.new_password')</label>
                            @error('new_password')
                            <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s6">
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                required class="validate @error('new_password') invalid @enderror">
                            <label for="new_password_confirmation">@lang('registration.confirmpwd')</label>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row" style="margin-bottom: 0">
                        <button class="btn waves-effect right" type="submit">@lang('general.change_password')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection