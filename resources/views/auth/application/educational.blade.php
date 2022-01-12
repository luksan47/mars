@extends('auth.application.app')

@section('educational-active') active @endsection

@section('form')

    <div class="card">
        <form method="POST" action="{{ route('application.store', ['page' => 'educational']) }}">
            @csrf
            <div class="card-content">
                <div class="row">
                    <x-input.text s=12 m=6 id='high_school' locale='user'
                        :value="$user->educationalInformation?->high_school" required />
                    <x-input.text s=12 m=6 id='year_of_graduation' locale='user' type='number' min="1895" :max="date('Y')"
                        :value="$user->educationalInformation?->year_of_graduation" required />
                    <x-input.text s=12 m=12 id='high_school_address' locale='application' text="Középiskola címe"
                        :value="$user->application?->high_school_address" required />

                    <x-input.text s=6 id='neptun' locale='user' :value="$user->educationalInformation?->neptun" required />
                    <x-input.text s=6 id='educational_email' locale='user' :value="$user->educationalInformation?->email"
                        required helper="lehetőleg @student.elte.hu-s" />

                    <div class="input-field col s12 m6">
                        <p><label>@lang('user.faculty')</label></p>
                        @foreach ($faculties as $faculty)
                            <p>
                                @php $checked = old('faculty') !== null && in_array($faculty->id, old('faculty')) || in_array($faculty->id, $user->faculties->pluck('id')->toArray()) @endphp
                                <x-input.checkbox only_input :text="$faculty->name" name="faculty[]"
                                    value="{{ $faculty->id }}" :checked='$checked' />
                            </p>
                        @endforeach
                        @error('faculty')
                            <blockquote class="error">@lang('user.faculty_must_be_filled')</blockquote>
                        @enderror
                    </div>
                    <x-input.text s=12 id='graduation_avarage' locale='application' type='number' step="0.01" min="0"
                        max="5" text="Érettségi átlaga" :value="$user->application?->graduation_avarage" required
                        helper='Az összes érettségi tárgy hagyományos átlaga' />
                </div>
                <div class="row" style="margin:0">
                    @livewire('parent-child-form', ['title' => "Szak(ok)", 'name' => 'programs', 'items' => $user->educationalInformation?->program])
                </div>
                <div class="row" style="margin:0">
                    @livewire('parent-child-form', [
                        'title' => "Van lezárt egyetemi félévem",
                        'name' => 'semester_avarage',
                        'helper' => 'Hagyományos átlag a félév(ek)ben',
                        'optional' => true,
                        'items' => $user->application?->semester_avarage])
                </div>
                <div class="row" style="margin:0">
                    @livewire('parent-child-form', [
                        'title' => "Van nyelvvizsgám",
                        'name' => 'language_exam',
                        'helper' => 'Nyelv, szint, típus',
                        'optional' => true,
                        'items' => $user->application?->language_exam])
                </div>
                <div class="row" style="margin:0">
                    @livewire('parent-child-form', [
                        'title' => "Van versenyeredményem",
                        'name' => 'competition',
                        'optional' => true,
                        'items' => $user->application?->competition])
                </div>
                <div class="row" style="margin:0">
                    @livewire('parent-child-form', [
                        'title' => "Van publikációm",
                        'name' => 'publication',
                        'optional' => true,
                        'items' => $user->application?->publication])
                </div>
                <div class="row" style="margin:0">
                    @livewire('parent-child-form', [
                        'title' => "Tanultam külföldön",
                        'name' => 'foreign_studies',
                        'optional' => true,
                        'items' => $user->application?->foreign_studies])
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
