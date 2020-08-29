@extends('layouts.app')
@section('title')
<i class="material-icons left">table_view</i>@lang('secretariat.module')
@endsection

@section('content')

<div class="row">
  <div class="col s12 m12 l12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">@lang('secretariat.create_course')</span>

        <form method="POST" action="{{ route('secretariat.course.add') }}">
        @csrf
        <div class="row">
            <div class="input-field col s12 l6">
                <input type="text" id="code" name="code" class="autocomplete validate @error('code') invalid @enderror" value="{{ old('code') }}" required>
                <label for="code">@lang('secretariat.code')</label>
                @error('code') <span class="helper-text" data-error="{{ $message }}"></span> @enderror
            </div>
            <div class="input-field col s12 m12 l6">
                @include("utils/select", ['elements' => \App\Workshop::all(), 'element_id' => 'workshop', 'label' => 'secretariat.workshop'])
            </div>
            <div class="input-field col s12">
                <input id="name" name="name" type="text" class="validate @error('name') invalid @enderror" value="{{ old('name') }}" required>
                <label for="name">@lang('secretariat.name')</label>
                @error('name') <span class="helper-text" data-error="{{ $message }}"></span> @enderror
            </div>
            <div class="input-field col s12">
                <input id="name_english" name="name_english" type="text" class="validate @error('name_english') invalid @enderror" value="{{ old('name_english') }}" required>
                <label for="name_english">@lang('secretariat.name_english')</label>
                @error('name_english') <span class="helper-text" data-error="{{ $message }}"></span> @enderror
            </div>
            <!-- TODO: make it a select -->
            <div class="input-field col s12 m6 l6">
            @include("utils/select", ['elements' => \App\Course::types(), 'element_id' => 'type', 'label' => 'secretariat.type'])
            </div>
            <div class="input-field col s6 m3 l3">
                <input id="credits" name="credits" type="number" class="validate @error('credits') invalid @enderror" min="0" value="{{ old('credits') }}" required>
                <label for="credits">@lang('secretariat.credits')</label>
                @error('credits') <span class="helper-text" data-error="{{ $message }}"></span> @enderror
            </div>
            <div class="input-field col s6 m3 l3">
                <input id="hours" name="hours" type="text" class="validate @error('hours') invalid @enderror" value="{{ old('hours') }}" required>
                <label for="hours">@lang('secretariat.hours')</label>
                @error('hours') <span class="helper-text" data-error="{{ $message }}"></span> @enderror
            </div>
            <div class="input-field col s12 m12 l6">
                @include("utils/select", ['elements' => $users, 'element_id' => 'teacher', 'label' => 'secretariat.teacher'])
            </div>
            <div class="input-field col s12 m12 l3">
                @include("utils/select", ['elements' => \App\Semester::all(), 'element_id' => 'semester', 'label' => 'secretariat.semester'])
            </div>
            <div class="input-field col s12 m12 l3">
                <button class="btn waves-effect right" type="submit">@lang('secretariat.create_course')</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
