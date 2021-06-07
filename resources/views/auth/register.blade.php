@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12 l8 xl6 offset-l2 offset-xl3">
        <div class="card">
            <div class="card-image">
                <img src="/img/EC_building.jpg">
                <span class="card-title">@lang('general.register')</span>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card-content">
                    <blockquote>
                        @if($user_type == \App\Models\Role::COLLEGIST)
                        <a href="{{ route('register.guest') }}">
                            @lang('registration.collegist_to_tenant')</a>
                        @else
                        <a href="{{ route('register') }}">
                            @lang('registration.tenant_to_collegist')</a>
                        @endif
                    </blockquote>
                    <div class="divider"></div>
                    @foreach ($errors->all() as $error)
                        <blockquote class="error">{{ $error }}</blockquote>
                    @endforeach
                    {{--basic information--}}
                    <div class="section">
                        <div class="row">
                            <x-input.text id="email"      type="email"    locale="registration" required autocomplete="email" autofocus/>
                            <x-input.text id="password"   locale="registration" type="password" required autocomplete="new-password"/>
                            <x-input.text id="confirmpwd" locale="registration" name="password_confirmation" type="password" required autocomplete="new-password"/>
                        </div>
                        <input type="text" name="user_type" id="user_type" value="{{ $user_type }}" readonly hidden>
                    </div>
                    <div class="divider"></div>
                    {{--personal information--}}
                    <div class="section">
                        <div class="card-title">@lang('user.user_data')</div>
                        <div class="row">
                            <x-input.text id='name' required autocomplete='name' locale='user'/>
                            <x-input.text l=6 id='place_of_birth' required locale='user'/>
                            <x-input.datepicker l=6 id='date_of_birth' required locale='user'/>
                            <x-input.text id='mothers_name' required locale='user'/>
                            <x-input.text id='phone_number' type='tel' required
                                pattern="[+][0-9]{1,4}[-\s()0-9]*" minlength="8" maxlength="18"
                                locale='user' helper='+36 (20) 123-4567'/>
                        </div>
                    </div>
                    <div class="divider"></div>
                    {{--contact information--}}
                    <div class="section">
                    <div class="card-title">@lang('user.contact')</div>
                    <div class="row">
                        <x-input.select id="country" :elements="$countries" default="Hungary" locale="user"/>
                        <x-input.text l=6 id='county'        locale='user' required/>
                        <x-input.text l=6 id='zip_code'      locale='user' type='number' required/>
                        <x-input.text id='city'              locale='user' required/>
                        <x-input.text id='street_and_number' locale='user' required/>
                    </div>
                    @if($user_type == \App\Models\Role::COLLEGIST)
                    <div class="divider"></div>
                    {{--educational information--}}
                    <div class="section">
                        <div class="card-title">@lang('user.information_of_studies')</div>
                        <div class="row">
                            <x-input.text id='high_school' locale='user' required/>
                            <x-input.text s=6 id='year_of_graduation' locale='user' type='number' min="1895" :max="date('Y')" required/>
                            <x-input.text s=6 id='year_of_acceptance' locale='user' type='number' min="1895" :max="date('Y')" required/>
                            <x-input.text s=6 id='neptun' locale='user' required/>
                            @php $elements = \App\Models\Role::possibleObjectsFor(\App\Models\Role::COLLEGIST)->map(function ($object) {
                                return (object)['id' => $object->id, 'name' => __('role.'.$object->name)];});
                            @endphp
                            <x-input.select s=6 id="collegist_status" text="user.status" :elements="$elements"/>
                            <div class="col s12">
                                <div class="input-field s6 inline" style="margin-left:0">
                                    <x-input.text only_input id='educational_email' locale='user' required/>
                                </div>
                                @student.elte.hu
                            </div>
                            {{--faculty--}}
                            <div class="input-field col s12">
                                <p><label>@lang('user.faculty')</label></p>
                                @foreach($faculties as $faculty)
                                <p>
                                    @php $checked = old('faculty') !== null && in_array($faculty->id, old('faculty')) @endphp
                                    <x-input.checkbox only_input :text="$faculty->name" name="faculty[]" value="{{$faculty->id}}" :checked='$checked' @endif />
                                </p>
                                @endforeach
                                @error('faculty')
                                <blockquote class="error">@lang('user.faculty_must_be_filled')</blockquote>
                                @enderror
                            </div>
                            {{--workshop--}}
                            <div class="input-field col s12">
                                <p><label>@lang('user.workshop')</label></p>
                                @foreach($workshops as $workshop)
                                <p>
                                    @php $checked = old('workshop') !== null && in_array($workshop->id, old('workshop')) @endphp
                                    <x-input.checkbox only_input :text="$workshop->name" name="workshop[]" value="{{$workshop->id}}" :checked='$checked' @endif />
                                </p>
                                @endforeach
                                @error('workshop')
                                <blockquote class="error">@lang('user.workshop_must_be_filled')</blockquote>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="divider"></div>
                    <div class="section">
                        <div class="row">
                            <div class="col s12 l8">
                                <p><label>
                                    <input type="checkbox" name="gdpr" id="qdpr" value="qdpr" required
                                        class="filled-in checkbox-color" />
                                    <span>@lang('auth.i_agree_to') <a href="{{ route('privacy_policy') }}"
                                            target="_blank">@lang('auth.privacy_policy').</a></span>
                                </label></p>
                            </div>
                            <x-input.button l=4 class='right' text='general.register'/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
