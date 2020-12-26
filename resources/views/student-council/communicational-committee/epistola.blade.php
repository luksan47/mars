@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('role.communicational-committee')</a>
@endsection
@section('student_council_module') active @endsection

@section('content')
<div class="row">
    @foreach ($news as $article)
    <div class="col s12 m6">
        <div class="card sticky-action">
            @if($article->picture)
            <div class="card-image waves-effect waves-block waves-light">
            <img class="activator" id="{{$article->id}}" src="{{ $article->picture }}" onerror="standby({{$article->id}})">
            </div>
            @endif
            <div class="card-content">
            <span class="card-title activator grey-text text-darken-4">{{$article->title}}<i class="material-icons right">more_vert</i></span>
            <p>{{$article->subtitle}}</p>
            </div>
            <div class="card-action">
                <a href="{{$article->details}}">Details</a>
                <a href="{{$article->website}}">Website</a>
                <a href="{{$article->registration}}">Register</a>
                <a href="{{$article->facebook_event}}">FB event</a>
                <a href="{{$article->website}}">Website</a>
            </div>
            <div class="card-reveal">
            <span class="card-title grey-text text-darken-4">{{$article->title}}<i class="material-icons right">close</i></span>
            <p>{{$article->description}}</p>
            <p>Jelentkezési határidő: <i>{{$article->registration_deadline}}</i></p>
            <p>Kitöltési határidő: <i>{{$article->filling_deadline}}</i></p>
            <p>Dátum: <i>{{$article->date}} - {{$article->end_date}}</i></p>
            <img src="{{ $article->big_picture }}">
            </div>
        </div>
    </div>
    @endforeach
</div>
<script>
function standby(id) {
    document.getElementById(id).src = "{{ url('/img/committee-logos/kommbiz.jpg') }}"
}
</script>
@endsection
