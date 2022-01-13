@extends('auth.application.app')

@section('questions-active') active @endsection

@section('form')


    <div class="card">
        <form method="POST" action="{{ route('application.store', ['page' => 'questions']) }}">
            @csrf
            <div class="card-content">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <p style="margin-bottom:10px"><label style="font-size: 1em">Megpályázni kívánt műhely</label></p>
                        @foreach ($workshops as $workshop)
                            <p>
                                @php $checked = old('workshop') !== null && in_array($workshop->id, old('workshop')) || in_array($workshop->id, $user->workshops->pluck('id')->toArray()) @endphp
                                <x-input.checkbox only_input :text="$workshop->name" name="workshop[]"
                                    value="{{ $workshop->id }}" :checked='$checked' />
                            </p>
                        @endforeach
                        @error('workshop')
                            <blockquote class="error">@lang('user.workshop_must_be_filled')</blockquote>
                        @enderror
                    </div>
                    <div class="input-field col s12 m6">
                        <p style="margin-bottom:10px"><label style="font-size: 1em">Megpályázni kívánt státusz</label></p>
                            <p>
                                @php $checked = old('status') ?  old('status') == 'resident' : $user->isResident() @endphp
                                <label>
                                    <input type="radio" name="status" value="resident"
                                        {{ $checked ? 'checked' : '' }}>
                                    <span>@lang('role.resident')</span>
                                </label>
                            </p>
                            <p>
                                @php $checked = old('status') ?  old('status') == 'extern' : $user->isExtern() @endphp
                                <label>
                                    <input type="radio" name="status" value="extern"
                                        {{ $checked ? 'checked' : '' }}>
                                    <span>@lang('role.extern')</span>
                                </label>
                            </p>
                        @error('status')
                            <blockquote class="error">A státusz kitöltése kötelező</blockquote>
                        @enderror
                    </div>
                    <x-input.textarea id="question_1" locale='application' text="Honnan hallott a Collegiumról?" :value="$user->application?->question_1"/>
                    <x-input.textarea id="question_2" locale='application' text="Miért kíván a Collegium tagja lenni?" helper="≈300-500 karakter" :value="$user->application?->question_2" />
                    <x-input.textarea id="question_3" locale='application'
                        text="Tervez-e tovább tanulni a diplomája megszerzése után? Milyen tervei vannak az egyetem után?" :value="$user->application?->question_3"/>
                    <x-input.textarea id="question_4" locale='application'
                        text="Részt vett-e közéleti tevékenységben? Ha igen, röviden jellemezze!"
                        helper="Pl. diákönkormányzati tevékenység, önkéntesség, szervezeti tagság. (nem kötelező)"
                        :value="$user->application?->question_4" />
                </div>

            </div>
            <div class="card-action">
                <div class="row" style="margin-bottom: 0">
                    <x-input.button only_input class="right" text="general.save" />
                </div>
            </div>
        </form>
    </div>

@endsection
