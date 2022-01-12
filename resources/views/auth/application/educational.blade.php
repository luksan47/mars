@extends('auth.application.app')

@section('educational-active') active @endsection

@section('form')

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

                <x-input.text s=12 id='program' locale='user' text="Szak(ok)"
                    :value="$user->educationalInformation?->program" required />

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
