@extends('layouts.app')

@section('title')
    Jelentkezés
@endsection


@section('content')
    <div class="card">
        <div class="card-content">
            <h6>Jelentkezés státusza: <i>Folyamatban</i></h6>
            <h6>Jelentkezési határidő:
                <i>{{ $deadline->format('Y-m-d H:i') }}</i>
                @if ($deadline_extended)
                    <small class="coli-text text-orange">(Meghosszabbítva)</small>
                @endif
            </h6>
            Hátra van: <i>{{ \Carbon\Carbon::now()->diffInDays($deadline, false) }}</i> nap.

            <blockquote>
                <p>A jelentkezése jelen állapotában még nem látható a felvételiztető bizottság számára! Miután minden
                    szükséges kérdést megválaszolt és fájlt feltöltött, kérjük, véglegesítse a jelentkezését.</p>
                <p>Kérjük figyeljen a határidőre, mert utána már nem lesz lehetősége véglegesíteni azt.</p>
                <p>Amennyiben bármi kérdése lenne a felvételivel kapcsolatban, kérjük, írjon a <a
                        href="mailto:titkarsag@eotvos.elte.hu">titkarsag@eotvos.elte.hu</a> e-mail címre. Ha technikai
                    probléma adódna, kérjük, jelezze felénk a <a href="mailto:root@eotvos.elte.hu">root@eotvos.elte.hu</a>
                    e-mail címen.</p>
            </blockquote>
        </div>
    </div>
    <div class="card">
        <form method="POST" action="#">
            @csrf
            <div class="card-content">
                {{-- personal information --}}
                <div class="card-title">@lang('user.user_data')</div>
                <div class="row">
                    <x-input.text id='name' required autocomplete='name' locale='user' :value="$user->name" />
                    <x-input.text l=6 id='place_of_birth' required locale='user'
                        :value="$user->personalInformation->place_of_birth" />
                    <x-input.datepicker l=6 id='date_of_birth' required locale='user'
                        :value="$user->personalInformation->date_of_birth" />
                    <x-input.text id='mothers_name' required locale='user'
                        :value="$user->personalInformation->mothers_name" />
                    <x-input.text id='phone_number' type='tel' required pattern="[+][0-9]{1,4}[-\s()0-9]*" minlength="8"
                        maxlength="18" locale='user' helper='+36 (20) 123-4567'
                        :value="$user->personalInformation->phone_number" />
                </div>
                <div class="divider" style="margin-bottom: 20px"></div>
                {{-- contact information --}}
                <div class="card-title">@lang('user.contact')</div>
                <div class="row" style="margin-bottom: 0">
                    <x-input.select id="country" :elements="$countries" default="Hungary" locale="user"
                        :value="$user->personalInformation->country" />
                    <x-input.text l=6 id='county' locale='user' required :value="$user->personalInformation->county" />
                    <x-input.text l=6 id='zip_code' locale='user' type='number' required
                        :value="$user->personalInformation->zip_code" />
                    <x-input.text id='city' locale='user' required :value="$user->personalInformation->city" />
                    <x-input.text id='street_and_number' locale='user' required
                        :value="$user->personalInformation->street_and_number" />
                </div>
            </div>
            <div class="card-action">
                <div class="row" style="margin-bottom: 0">
                    <x-input.button only_input class="right" text="general.save" />
                </div>
            </div>
        </form>
    </div>
    <div class="card">
        <form method="POST" action="#">
            <div class="card-content">
                {{-- educational information --}}
                <div class="card-title">@lang('user.information_of_studies')</div>
                <div class="row">
                    <x-input.text s=12 m=6 id='high_school' locale='user' required />
                    <x-input.text s=12 m=6 id='year_of_graduation' locale='user' type='number' min="1895" :max="date('Y')"
                        :value="$user->educationalInformation?->year_of_graduation" required />
                    <x-input.text s=12 m=12 id='high_school_address' locale='application' text="Középiskola címe"
                        required />

                    <x-input.text s=6 id='neptun' locale='user' :value="$user->educationalInformation?->neptun" required />
                    <div class="col s6">
                        <div class="input-field s10 inline" style="margin-left:0">
                            <x-input.text only_input id='educational_email' locale='user'
                                :value="$user->educationalInformation?->educational_email" required />
                        </div>
                        @student.elte.hu
                    </div>
                    <x-input.text s=12 id='program' locale='user' text="Szak(ok)"
                        :value="$user->educationalInformation?->program" required />

                    {{-- workshop --}}
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
                    {{-- faculty --}}
                    <div class="input-field col s12 m6">
                        <p><label>@lang('user.faculty')</label></p>
                        @foreach ($faculties as $faculty)
                            <p>
                                @php $checked = old('faculty') !== null && in_array($faculty->id, old('faculty')) @endphp
                                <x-input.checkbox only_input :text="$faculty->name" name="faculty[]"
                                    value="{{ $faculty->id }}" :checked='$checked' />
                            </p>
                        @endforeach
                        @error('faculty')
                            <blockquote class="error">@lang('user.faculty_must_be_filled')</blockquote>
                        @enderror
                    </div>

                    <x-input.text s=12 id='graduation_avarage' locale='application' type='number' min="0" max="5"
                        text="Érettségi átlaga" :value="$user->educationalInformation?->graduation_avarage" required
                        helper='Az összes érettségi tárgy hagyományos átlaga' />

                    <x-input.checkbox s=3 text="Van lezárt egyetemi félévem" />
                    <div class="col s9">
                        <div class="input-field">
                            <x-input.text only_input id='semester_avarage_1' name="semester_avarage[]" locale='application'
                                type='number' min="0" max="5" text="1. félév"
                                :value="$user->educationalInformation?->semester_avarage" required
                                helper='Hagyományos átlag' />
                        </div>
                        <div class="input-field">
                            <x-input.text only_input id='semester_avarage_2' locale='application_avarage[]' type='number'
                                min="0" max="5" text="2. félév" :value="$user->educationalInformation?->semester_avarage"
                                required helper='Hagyományos átlag' />
                        </div>
                    </div>

                    <x-input.checkbox s=12 text="Van nyelvvizsgám" />

                    <x-input.checkbox s=12 text="Van versenyeredményem" />

                    <x-input.checkbox s=12 text="Van publikációm" />

                    <x-input.checkbox s=12 text="Tanultam külföldön" />

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

                </div>
            </div>
            <div class="card-action">
                <div class="row" style="margin-bottom: 0">
                    <x-input.button only_input class="right" text="general.save" />
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <form method="POST" action="#">
            <div class="card-content">
                <div class="card-title">Felvételihez kapcsolódó kérdések</div>
                <div class="row">
                    <x-input.textarea id="question_1" locale='application' text="Honnan hallott a Collegiumról?" required />
                    <x-input.textarea id="question_2" locale='application' text="Miért kíván a Collegium tagja lenni?"
                        required helper="≈300-500 karakter" />
                    <x-input.textarea id="question_3" locale='application'
                        text="Tervez-e tovább tanulni a diplomája megszerzése után? Milyen tervei vannak az egyetem után?"
                        required />
                    <x-input.textarea id="question_4" locale='application'
                        text="Részt vett-e közéleti tevékenységben? Ha igen, röviden jellemezze!"
                        helper="Pl. diákönkormányztai tevékenység, önkéntesség, szervezeti tagság. (nem kötelező)" />
                </div>
            </div>
            <div class="card-action">
                <div class="row" style="margin-bottom: 0">
                    <x-input.button only_input class="right" text="general.save" />
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <form method="POST" action="#" enctype='multipart/form-data'>

            <div class="card-content">
                <div class="card-title">Feltöltések</div>
                A pályázatnak az alábbiakat kell tartalmaznia:
                <ul style="margin-left:20px;margin-top:0">
                    <li style="list-style-type: circle !important">Hagyományos önéletrajz</li>
                    <li style="list-style-type: circle !important">Felvételi határozat (Neptun: Tanulmányok - Hivatalos bejegyzések menüpont alatt letölthető)</li>
                    <li style="list-style-type: circle !important">Opcionális: oklevelek, igazolások</li>
                </ul>

                <div class="row">
                    <div class="col"><h6>Feltoltes</h6></div>

                    {{-- TODO max size --}}
                    <x-input.text id="file_name" text="Fájl megnevezése" required />
                    <x-input.file id="file" accept=".pdf,.jpg,.png,.jpeg" text="Böngészés" required />
                </div>
                    <x-input.button only_input class="right" text="general.upload" />
                    <blockquote>A feltölteni kívánt fájlok maximális mérete: 2 MB, az engedélyezett formátumok: .pdf, .jpg, .jpeg, .png</blockquote>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')

@endpush
