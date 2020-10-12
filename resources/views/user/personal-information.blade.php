{{-- Personal information --}}
@can('viewPersonalInformation', $user)
<div class="card">
    <div class="card-content">
        <div class="card-title">@lang('user.personal_information')</div>
        <table>
            <tbody>
                <tr>
                    <th scope="row">@lang('registration.email')</th>
                    <td>
                        @if($modifiable_email ?? false)
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
                        @else
                        {{ $user->email }}
                        @endif
                    </td>
                </tr>
                @if($user->hasPersonalInformation())
                    <tr>
                        <th scope="row">@lang('user.phone_number')</th>
                        <td>
                            @if($modifiable_phone ?? false)
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
                            @else
                                {{ $user->personalInformation->phone_number }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('user.place_and_date_of_birth')</th>
                        <td>
                            {{ $user->personalInformation->place_of_birth }},  {{ $user->personalInformation->date_of_birth }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('user.mothers_name')</th>
                        <td>
                            {{ $user->personalInformation->mothers_name }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('user.address')</th>
                        <td>
                            {{ $user->personalInformation->country }}, <small>{{ $user->personalInformation->county }}</small>
                            <br>
                            {{ $user->personalInformation->zip_code }} {{ $user->personalInformation->city }},
                            <small>{{ $user->personalInformation->street_and_number }} </small>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endcan