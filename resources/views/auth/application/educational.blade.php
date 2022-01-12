@extends('auth.application.app')

@section('educational-active') active @endsection

@section('form')

<div class="card">
    <form method="POST" action="#">
        <div class="card-content">
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
            </div>
            <div class="row" style="margin:0">
                @livewire('parent-child-form', ['title' => "Van lezárt egyetemi félévem", 'name' => 'semester_avarage', 'helper' => 'Hagyományos átlag a félév(ek)ben'])
            </div>
            <div class="row" style="margin:0">
                @livewire('parent-child-form', ['title' => "Van nyelvvizsgám", 'name' => 'language_exam', 'helper' => 'Nyelv, szint, tipus'])
            </div>
            <div class="row" style="margin:0">
                @livewire('parent-child-form', ['title' => "Van versenyeredményem", 'name' => 'competition'])
            </div>
            <div class="row" style="margin:0">
                @livewire('parent-child-form', ['title' => "Van publikációm", 'name' => 'publication'])
            </div>
            <div class="row" style="margin:0">
                @livewire('parent-child-form', ['title' => "Tanultam külföldön", 'name' => 'foreign_studies'])
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
