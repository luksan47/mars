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
                            <form method="POST" action="{{ route('secretariat.user.update_email') }}">
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
                                <form method="POST" action="{{ route('secretariat.user.update_phone') }}">
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
                                </form>
                            @else
                                {{ $user->personalInformation->phone_number }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('user.place_and_date_of_birth')</th>
                        <td>
							@if($modifiable_place_of_birth ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update_place_of_birth') }}">
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
                                    <button id="place_of_birth_send_btn" class="btn-floating right waves-effect waves-light hide"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="place_of_birth_edit_btn" class="btn-floating right waves-effect waves-light"
                                        onclick="place_of_birth_editor()" style="margin-top:10px">
                                        <i class="material-icons">edit</i></a>
                                </form>
							@else
								{{ $user->personalInformation->place_of_birth }}
							@endif
							@if($modifiable_date_of_birth ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update_date_of_birth') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="date_of_birth" type="text" name="date_of_birth" size="30" 
                                            @if(!($errors->has('date_of_birth'))) disabled @endif
                                            style="margin:0" class="datepicker validate @error('date_of_birth') invalid @enderror"
											value="{{ old('date_of_birth') }}" required onfocus="M.Datepicker.getInstance(date_of_birth).open();">
                                        @error('date_of_birth')
                                        <span class="helper-text" data-error="{{ $message }}"></span>
                                        @enderror
                                    </div>
                                    <button id="date_of_birth_send_btn" class="btn-floating right waves-effect waves-light hide"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="date_of_birth_edit_btn" class="btn-floating right waves-effect waves-light"
                                        onclick="date_of_birth_editor()" style="margin-top:10px">
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
							@if($modifiable_mothers_name ?? false)
                                <form method="POST" action="{{ route('secretariat.user.update_mothers_name') }}">
                                    @csrf
                                    <div class="input-field inline" style="margin:0">
                                        <input id="mothers_name" type="text" name="mothers_name" size="30" 
                                            @if(!($errors->has('mothers_name'))) disabled @endif 
											style="margin:0" class="validate black-text @error('mothers_name') invalid @enderror"
											value="{{ old('mothers_name', $user->mothers_name) }}" required>
										@error('mothers_name')
										<span class="helper-text" data-error="{{ $message }}"></span>
										@enderror
                                    </div>
                                    <button id="mothers_name_send_btn" class="btn-floating right waves-effect waves-light hide"
                                        type="submit" style="margin-top:10px">
                                        <i class="material-icons">send</i></button>
                                    <a id="mothers_name_edit_btn" class="btn-floating right waves-effect waves-light"
                                        onclick="mothers_name_editor()" style="margin-top:10px">
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

@push('scripts')
    <script>
        function phone_editor(){
            document.getElementById('phone_number').disabled=false;
            document.getElementById('phone_number').value="+36 ";
            document.getElementById('phone_edit_btn').classList.add('hide');
            document.getElementById('phone_send_btn').classList.remove('hide');
            document.getElementById('phone_format').classList.remove('hide');
        }
        function mail_editor(){
            document.getElementById('email').disabled=false;
            document.getElementById('email').value="";
            document.getElementById('email').focus();
            document.getElementById('email_edit_btn').classList.add('hide');
            document.getElementById('email_send_btn').classList.remove('hide');
        }
        function mothers_name_editor(){
			document.getElementById('mothers_name').disabled=false;
            document.getElementById('mothers_name').value="";
            document.getElementById('mothers_name').focus();
            document.getElementById('mothers_name_edit_btn').classList.add('hide');
            document.getElementById('mothers_name_send_btn').classList.remove('hide');
		}
		function place_of_birth_editor(){
			document.getElementById('place_of_birth').disabled=false;
            document.getElementById('place_of_birth').value="";
            document.getElementById('place_of_birth').focus();
            document.getElementById('place_of_birth_edit_btn').classList.add('hide');
            document.getElementById('place_of_birth_send_btn').classList.remove('hide');
		}
		function date_of_birth_editor(){
			document.getElementById('date_of_birth').disabled=false;
            document.getElementById('date_of_birth').value="";
            document.getElementById('date_of_birth').focus();
            document.getElementById('date_of_birth_edit_btn').classList.add('hide');
            document.getElementById('date_of_birth_send_btn').classList.remove('hide');
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
