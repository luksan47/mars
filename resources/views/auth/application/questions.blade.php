@extends('auth.application.app')

@section('questions-active') active @endsection

@section('form')


    <div class="card">
        <form method="POST" action="{{ route('application.store', ['page' => 'questions']) }}">
            @csrf
            <div class="card-content">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <p><label>Megpályázni kívánt műhely</label></p>
                        @foreach ($workshops as $workshop)
                            <p>
                                @php $checked = old('workshop') !== null && in_array($workshop->id, old('workshop')) @endphp
                                <x-input.checkbox only_input :text="$workshop->name" name="workshop[]"
                                    value="{{ $workshop->id }}" :checked='$checked' />
                            </p>
                        @endforeach
                        @error('workshop')
                            <blockquote class="error">@lang('user.workshop_must_be_filled')</blockquote>
                        @enderror
                    </div>
                    <div class="input-field col s12 m6">
                        <p><label>Megpályázni kívánt státusz</label></p>
                        @foreach (\App\Models\Role::possibleObjectsFor(\App\Models\Role::COLLEGIST) as $status)
                            <p>
                                @php $checked = old('status') !== null && in_array($status->id, old('status')) @endphp
                                <label>
                                    <input type="radio" name="status[]" value="{{ $status->id }}"
                                        {{ $checked ? 'checked' : '' }}>
                                    <span>@lang('role.' . $status->name)</span>
                                </label>
                            </p>
                        @endforeach
                        @error('status')
                            <blockquote class="error">TODO</blockquote>
                        @enderror
                    </div>
                    <x-input.textarea id="question_1" locale='application' text="Honnan hallott a Collegiumról?" />
                    <x-input.textarea id="question_2" locale='application' text="Miért kíván a Collegium tagja lenni?" helper="≈300-500 karakter" />
                    <x-input.textarea id="question_3" locale='application'
                        text="Tervez-e tovább tanulni a diplomája megszerzése után? Milyen tervei vannak az egyetem után?"/>
                    <x-input.textarea id="question_4" locale='application'
                        text="Részt vett-e közéleti tevékenységben? Ha igen, röviden jellemezze!"
                        helper="Pl. diákönkormányzati tevékenység, önkéntesség, szervezeti tagság. (nem kötelező)" />
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
