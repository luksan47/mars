@extends('layouts.app')
@section('title')
<i class="material-icons left">table_view</i>@lang('secretariat.module')
@endsection

@section('content')

<div class="row">
  <div class="col s12 m12 l12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">@lang('secretariat.reserve')</span>

        <form method="POST" action="{{ route('secretariat.schedule.send') }}">
        @csrf
        <div class="row">
            <!-- TODO: show for only one semester -->
            <div class="input-field col s12 m6">
                @include("utils/select", ['elements' => \App\Course::all(), 'element_id' => 'course', 'label' => 'secretariat.course'])
            </div>
            <!-- TODO: make it a select -->
            <div class="input-field col s12 m6">
                @include("utils/select", ['elements' => \App\Classroom::all(), 'element_id' => 'classroom', 'label' => 'secretariat.classroom'])
            </div>

            <div class="input-field col s12 m6">
                <select id="course_day" name="course_day">
                    <option value="0">@lang('general.monday')</option>
                    <option value="1">@lang('general.tuesday')</option>
                    <option value="2">@lang('general.wednesday')</option>
                    <option value="3">@lang('general.thursday')</option>
                    <option value="4">@lang('general.friday')</option>
                    <option value="5">@lang('general.saturday')</option>
                    <option value="6">@lang('general.sunday')</option>
                </select>
                <label>@lang('secretariat.course_day')</label>
                @error('course_day')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>

            <div class="input-field col s12 m6">
                <input type="text" class="timepicker validate" id="course_time" name="course_time"
                    value="{{ old('course_time') }}" required>
                <label for="course_time">@lang('secretariat.course_time')</label>
                @error('course_time')
                <blockquote class="error">{{ $message }}</blockquote>
                @enderror
            </div>

            <div class="input-field col s12 m12 l12">
                <button class="btn waves-effect right" type="submit">@lang('secretariat.reserve')</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('.timepicker').timepicker({
            defaultTime: '18:00',
            twelveHour: false,
        });
        $('select').formSelect();
    });
</script>
@endsection
