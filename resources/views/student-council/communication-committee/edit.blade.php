@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb" >@lang('role.communication-committee')</a>
<a href="{{ route('epistola') }}" style="cursor: pointer" class="breadcrumb">Epistola Collegii</a>
<a href="#!" class="breadcrumb">Szerkesztés</a>
@endsection
@section('student_council_module') active @endsection

@section('content')

<div class="row">
    <div class="col s12 l8 push-l2">
        <div class="card">
            <div class="card-content">
                @if($epistola)
                <form method="POST" action="{{ route('epistola.delete', ['epistola' => $epistola->id]) }}">
                    @csrf
                    <button type="submit" class="btn-floating waves-effect right red" style="margin-right: 10px"><i class="material-icons">delete</i></button>
                </form>
                <form method="POST" action="{{ route('epistola.mark_as_sent', ['epistola' => $epistola->id]) }}">
                    @csrf
                    <button type="submit" class="btn-floating waves-effect right green" style="margin-right: 10px"><i class="material-icons">mark_email_read</i></button>
                </form>
                @endif
                <div class="card-title">{{ $epistola->title ?? "Új hír"}}</div>

                <form method="POST" action="{{ route('epistola.update_or_create') }}" enctype="multipart/form-data">
                    @csrf
                    @if($epistola)
                    <input type="hidden" name="id" value="{{$epistola->id}}">
                    @endif
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="title" name="title" type="text" class="validate @error('title') invalid @enderror" required
                                value="{{ $epistola->title ?? old('title')}}">
                            <label for="title">Cím*</label>
                            @error('title')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12">
                            <input id="subtitle" name="subtitle" type="text" class="validate @error('subtitle') invalid @enderror" required
                                value="{{ $epistola->subtitle ?? old('subtitle')}}">
                            <label for="subtitle">Alcím*</label>
                            @error('subtitle')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12">
                            
                            <textarea id="description" class="materialize-textarea validate @error('description') invalid @enderror" name="description" required
                                >{{ $epistola->description ?? old('description')}}</textarea>
                            <label for="description">Leírás*</label>
                            <span class="helper-text" @error('description') data-error="{{ $message }}" @enderror>Formázásra a 
                                <a href="https://www.markdownguide.org/cheat-sheet/" target="__blank">Markdown jelölései</a> használhatóak.</span>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l5">
                            <input id="date" name="date" type="text" class="validate datepicker @error('date') invalid @enderror"
                                value="{{ old('date') ?? ($epistola && $epistola->date != null ? $epistola->date->format('Y-m-d') : "") }}"
                                onfocus="M.Datepicker.getInstance(date).open();">
                            <label for="date">Dátum (esemény kezdete)</label>
                            @error('date')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l2">
                            <input id="time" name="time" type="text" class="validate timepicker @error('time') invalid @enderror"
                                value="{{old('time') ?? ($epistola && $epistola->time ? $epistola->time->format('h:m') : "") }}">
                            <label for="time">Időpont</label>
                            @error('time')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l5">
                            <input id="end_date" name="end_date" type="text" class="validate datepicker @error('end_date') invalid @enderror"
                                value="{{ old('end_date') ?? ($epistola && $epistola->end_date ? $epistola->end_date->format('Y-m-d') : "") }}"
                                onfocus="M.Datepicker.getInstance(end_date).open();">
                            <label for="end_date">Esemény vége</label>
                            @error('end_date')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input id="details_name_1" name="details_name_1" type="text" class="validate @error('details_name_1') invalid @enderror"
                                value="{{ $epistola->details_name_1 ?? old('details_name_1') }}">
                            <label for="details_name_1">További  infó neve</label>
                            @error('details_name_1')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="details_url_1" name="details_url_1" type="url" class="validate @error('details_url_1') invalid @enderror"
                                value="{{ $epistola->details_url_1 ?? old('details_url_1')}}">
                            <label for="details_url_1">További infó url</label>
                            @error('details_url_1')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="details_name_2" name="details_name_2" type="text" class="validate @error('details_name_2') invalid @enderror"
                                value="{{ $epistola->details_name_2 ?? old('details_name_2')}}">
                            <label for="details_name_2">További infó neve</label>
                            @error('details_name_2')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="details_url_2" name="details_url_2" type="url" class="validate @error('details_url_2') invalid @enderror"
                                value="{{ $epistola->details_url_2 ?? old('details_url_2')}}">
                            <label for="details_url_2">További infó url</label>
                            @error('details_url_2')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="deadline_name" name="deadline_name" type="text" class="validate @error('deadline_name') invalid @enderror"
                                value="{{ $epistola->deadline_name ?? old('deadline_name') }}">
                            <label for="deadline_name">Határidő neve</label>
                            @error('deadline_name')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="deadline_date" name="deadline_date" type="text" class="validate datepicker @error('deadline_date') invalid @enderror"
                                value="{{ old('deadline_date') ?? ($epistola && $epistola->deadline_date ? $epistola->deadline_date->format('Y-m-d') : "")}}"
                                onfocus="M.Datepicker.getInstance(deadline_date).open();">
                            <label for="deadline_date">Határidő</label>
                            @error('deadline_date')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s12 m6">
                            <div class="btn waves-effect">
                                <span>Kép</span>
                                <input type="file" id="picture_upload" name="picture_upload" accept=".jpg,.png" value="{{ old('picture_upload') }}">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path @error('picture_upload') invalid @enderror" placeholder="Kép feltöltése" type="text" disabled>
                                @error('picture_upload')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>
                            <p style="">
                                <label>
                                    <input type="checkbox" name="approved" />
                                    <span>Nem töltök fel szerzői jog oltalma alatt álló képet.</span>
                                </label>
                                @error('approved')
                                    <blockquote>{{$message}}</blockquote>
                                @enderror
                            </p>
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="picture_path" name="picture_path" type="url" class="validate @error('picture_path') invalid @enderror"
                                value="{{ $epistola->picture_path ?? old('picture_path')}}">
                            <label for="picture_path">Vagy kép linkje</label>
                            @error('picture_path')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                            @if($epistola && $epistola->picture_path)
                            <img src="{{$epistola->picture_path}}" style="width: 100%">
                            @endif
                        </div>
                    </div>
                    @if($epistola)
                    <p>Feltöltő: {{$epistola->uploader->name}}</p>
                    @endif
                <button type="submit" class="btn-floating waves-effect right"><i class="material-icons">send</i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function(){
    $('.datepicker').datepicker({
        minDate : new Date(),
        format: 'yyyy-mm-dd',
        firstDay: 1,
        showClearBtn: true
    });
    $('.timepicker').timepicker({
        twelveHour: false,
        showClearBtn: true
    });
});
</script>
@endpush
@endsection
