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
                                value="{{ old('end_date') ?? ($epistola && $epistola->end_date ? $epistola->end_date->format('h:m') : "") }}"
                                onfocus="M.Datepicker.getInstance(end_date).open();">
                            <label for="end_date">Esemény vége</label>
                            @error('end_date')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l4">
                            <input id="further_details_url" name="further_details_url" type="url" class="validate @error('further_details_url') invalid @enderror"
                                value="{{ $epistola->further_details_url ?? old('further_details_url')}}">
                            <label for="further_details_url">További részletek</label>
                            @error('further_details_url')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l4">
                            <input id="website_url" name="website_url" type="url" class="validate @error('website_url') invalid @enderror"
                                value="{{ $epistola->website_url ?? old('website_url')}}">
                            <label for="website_url">Weboldal</label>
                            @error('website_url')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l4">
                            <input id="facebook_event_url" name="facebook_event_url" type="url" class="validate @error('facebook_event_url') invalid @enderror"
                                value="{{ $epistola->facebook_event_url ?? old('facebook_event_url')}}">
                            <label for="facebook_event_url">Facebook esemény</label>
                            @error('facebook_event_url')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input id="registration_url" name="registration_url" type="url" class="validate @error('registration_url') invalid @enderror"
                                value="{{ $epistola->registration_url ?? old('registration_url')}}">
                            <label for="registration_url">Regisztrációs link</label>
                            @error('registration_url')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="registration_deadline" name="registration_deadline" type="text" class="validate datepicker @error('registration_deadline') invalid @enderror"
                                value="{{ $epistola->registration_deadline ?? old('registration_deadline')}}"
                                onfocus="M.Datepicker.getInstance(registration_deadline).open();">
                            <label for="registration_deadline">Regisztráció határideje</label>
                            @error('registration_deadline')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input id="fill_url" name="fill_url" type="url" class="validate @error('fill_url') invalid @enderror"
                                value="{{ $epistola->fill_url ?? old('fill_url')}}">
                            <label for="fill_url">Kitöltési link</label>
                            @error('fill_url')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="filling_deadline" name="filling_deadline" type="text" class="validate datepicker @error('filling_deadline') invalid @enderror"
                                value="{{ $epistola->filling_deadline ?? old('filling_deadline')}}"
                                onfocus="M.Datepicker.getInstance(filling_deadline).open();">
                            <label for="filling_deadline">Kitöltés határideje</label>
                            @error('filling_deadline')
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
                                    <input type="checkbox" name="approved" required/>
                                    <span>Nem töltök fel szerzői jog oltalma alatt álló képet.*</span>
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
