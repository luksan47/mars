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
                        @if($modifiable ?? false)
                            <form method="POST" action="{{ route('secretariat.user.update') }}">
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
                                <button id="email_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                    type="submit" style="margin-top:10px">
                                    <i class="material-icons">send</i></button>
                                <a id="email_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                    onclick="editor('email')" style="margin-top:10px">
                                    <i class="material-icons">edit</i></a>
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
                            @if($modifiable ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
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
                                    <button id="phone_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="phone_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="phone_editor()" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
                            @else
                                {{ $user->personalInformation->phone_number }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('user.place_and_date_of_birth')</th>
                        <td>
							@if($modifiable ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="place_of_birth" type="text" name="place_of_birth" size="30" 
                                            @if(!($errors->has('place_of_birth'))) disabled @endif 
                                            style="margin:0" class="validate black-text @error('place_of_birth') invalid @enderror"
                                            value="{{ old('place_of_birth', $user->personalInformation->place_of_birth ) }}" required>
                                        @error('place_of_birth')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
                                    </div>
                                    <button id="place_of_birth_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="place_of_birth_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('place_of_birth')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
							@else
								{{ $user->personalInformation->place_of_birth }}
							@endif
							@if($modifiable ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="date_of_birth" type="text" name="date_of_birth" size="30" 
                                            @if(!($errors->has('date_of_birth'))) disabled @endif
                                            style="margin:0" class="datepicker black-text validate @error('date_of_birth') invalid @enderror"
											value="{{ old('date_of_birth', $user->personalInformation->date_of_birth) }}" required onfocus="M.Datepicker.getInstance(date_of_birth).open();">
                                        @error('date_of_birth')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
                                    </div>
                                    <button id="date_of_birth_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="date_of_birth_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('date_of_birth')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
							@else
								{{ $user->personalInformation->date_of_birth }}
							@endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('user.mothers_name')</th>
                        <td>
							@if($modifiable ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="mothers_name" type="text" name="mothers_name" size="30" 
                                            @if(!($errors->has('mothers_name'))) disabled @endif 
											style="margin:0" class="validate black-text @error('mothers_name') invalid @enderror"
											value="{{ old('mothers_name', $user->personalInformation->mothers_name) }}" required>
										@error('mothers_name')
										<span class="helper-text" data-error="{{ $message }}"></span>
										@enderror
                                    </div>
                                    <button id="mothers_name_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="mothers_name_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('mothers_name')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
                            @else
								{{ $user->personalInformation->mothers_name }}
                            @endif
                            
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('user.address')</th>
                        <td>
                            @if($modifiable ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="country" type="text" name="country" size="30" 
                                            placeholder="@lang('user.country')"
                                            @if(!($errors->has('country'))) disabled @endif 
											style="margin:0" class="validate black-text @error('country') invalid @enderror"
											value="{{ old('country', $user->personalInformation->country) }}" required>
										@error('country')
										<span class="helper-text" data-error="{{ $message }}"></span>
										@enderror
                                    </div>
                                    <button id="country_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="country_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('country')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="county" type="text" name="county" size="30" 
                                            placeholder="@lang('user.county')"
                                            @if(!($errors->has('country'))) disabled @endif 
											style="margin:0" class="validate black-text @error('county') invalid @enderror"
											value="{{ old('county', $user->personalInformation->county) }}" required>
										@error('county')
										<span class="helper-text" data-error="{{ $message }}"></span>
										@enderror
                                    </div>
                                    <button id="county_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="county_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('county')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="zip_code" type="text" name="zip_code" size="30" 
                                            placeholder="@lang('user.zip_code')"
                                            @if(!($errors->has('country'))) disabled @endif 
											style="margin:0" class="validate black-text @error('zip_code') invalid @enderror"
											value="{{ old('zip_code', $user->personalInformation->zip_code) }}" required>
										@error('zip_code')
										<span class="helper-text" data-error="{{ $message }}"></span>
										@enderror
                                    </div>
                                    <button id="zip_code_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="zip_code_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('zip_code')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="city" type="text" name="city" size="30" 
                                            placeholder="@lang('user.city')"
                                            @if(!($errors->has('country'))) disabled @endif 
											style="margin:0" class="validate black-text @error('city') invalid @enderror"
											value="{{ old('city', $user->personalInformation->city) }}" required>
										@error('city')
										<span class="helper-text" data-error="{{ $message }}"></span>
										@enderror
                                    </div>
                                    <button id="city_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="city_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('city')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
                                <form method="POST" action="{{ route('secretariat.user.update') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="street_and_number" type="text" name="street_and_number" size="30" 
                                            placeholder="@lang('user.street_and_number')"
                                            @if(!($errors->has('country'))) disabled @endif 
											style="margin:0" class="validate black-text @error('street_and_number') invalid @enderror"
											value="{{ old('street_and_number', $user->personalInformation->street_and_number) }}" required>
										@error('street_and_number')
										<span class="helper-text" data-error="{{ $message }}"></span>
										@enderror
                                    </div>
                                    <button id="street_and_number_send_btn" class="btn-floating right waves-effect waves-light hide btn-small"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="street_and_number_edit_btn" class="btn-floating right waves-effect waves-light btn-small"
                                        onclick="editor('street_and_number')" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
                            @else
                            {{ $user->personalInformation->country }}, <small>{{ $user->personalInformation->county }}</small>
                            <br>
                            {{ $user->personalInformation->zip_code }} {{ $user->personalInformation->city }},
                            <small>{{ $user->personalInformation->street_and_number }} </small>
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endcan

@push('scripts')
    <script>
        function editor(attribute){
            document.getElementById(attribute).disabled=false;
            document.getElementById(attribute).value="";
            document.getElementById(attribute).focus();
            document.getElementById(attribute+'_send_btn').classList.remove('hide');
            document.getElementById(attribute+'_edit_btn').classList.add('hide');
        }
        function phone_editor(){
            document.getElementById('phone_number').disabled=false;
            document.getElementById('phone_number').value="+36 ";
            document.getElementById('phone_number').focus();
            document.getElementById('phone_edit_btn').classList.add('hide');
            document.getElementById('phone_send_btn').classList.remove('hide');
            document.getElementById('phone_format').classList.remove('hide');
        }
		$(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                firstDay: 1,
                yearRange: 50,
                maxDate: new Date(),
            });
        });
		
    </script>
@endpush
