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
        <div class="row">
            <div class="input-field col s12 l6">
                <input type="text" id="code" name="code" class="autocomplete validate" value="{{ old('code') }}" required>
                <label for="code">@lang('secretariat.code')</label>
                @error('code')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
            <!-- TODO: make it a select -->
            <div class="input-field col s12 m12 l6">
                <input id="workshop" name="workshop" type="number" class="validate" value="{{ old('workshop') }}" required>
                <label for="workshop">@lang('secretariat.workshop')</label>
                @error('workshop')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
            <div class="input-field col s12">
                <input id="name" name="name" type="text" class="validate" value="{{ old('name') }}" required>
                <label for="name">@lang('secretariat.name')</label>
                @error('name')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
            <div class="input-field col s12">
                <input id="name_english" name="name_english" type="text" class="validate" value="{{ old('name_english') }}" required>
                <label for="name_english">@lang('secretariat.name_english')</label>
                @error('name_english')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
            <!-- TODO: make it a select -->
            <div class="input-field col s12 m6 l6">
                <input id="type" name="type" type="text" class="validate" value="{{ old('type') }}" required>
                <label for="type">@lang('secretariat.type')</label>
                @error('type')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
            <div class="input-field col s6 m3 l3">
                <input id="credits" name="credits" type="number" class="validate" value="{{ old('credits') }}" required>
                <label for="credits">@lang('secretariat.credits')</label>
                @error('credits')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
            <div class="input-field col s6 m3 l3">
                <input id="hours" name="hours" type="text" class="validate" value="{{ old('hours') }}" required>
                <label for="hours">@lang('secretariat.hours')</label>
                @error('hours')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>
            <div class="input-field col s12 m12 l5">
                @include("select-user")
            </div>
            
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
