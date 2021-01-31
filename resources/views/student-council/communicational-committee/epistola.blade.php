@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('role.communicational-committee')</a>
@endsection
@section('student_council_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <h3>Epistola Collegii
            @can('create', \App\Models\EpistolaNews::class)
            <a class="btn-floating"><i class="material-icons">add</i></a>
            @endif
            @can('send', \App\Models\EpistolaNews::class)
            <a class="btn-floating green"><i class="material-icons">send</i></a>
            @endif
        </h3>
    </div>
</div>
<div class="row">
    @foreach ($news as $article)
    <div class="col s12 m6">
        <div class="card hoverable
            @if($article->shouldBeSent())
            @can('send', \App\Models\EpistolaNews::class)
                red lighten-4
            @endcan @endif">
            <div class="card-image waves-effect waves-block waves-light activator">
                <img class="activator" id="{{$article->id}}" src="{{ $article->picture ?? url('/img/committee-logos/kommbiz.jpg')}}" onerror="standby({{$article->id}})">
                <span class="card-title ">{{$article->title}}</span>
            </div>
            <div class="card-content activator">
                <i class="material-icons float right activator">more_vert</i>
                <p>{{$article->subtitle}}</p>
                <p><i>{{$article->date_time}}</i></p>
                @can('send', \App\Models\EpistolaNews::class)
                @if($article->valid_until)
                    <p><i @if($article->shouldBeSent()) class="red-text" @endif>Releváns eddig: {{$article->valid_until}}</i></p>
                @endif
                @endcan
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">{{$article->title}}<i class="material-icons right">close</i></span>
                <i>{{$article->date_time}}</i>
                <p>{{$article->description}}</p>
                @if($article->registration_deadline)
                    <p>Jelentkezési határidő: <i>{{$article->registration_deadline}}</i></p>
                @endif
                @if($article->filling_deadline)
                    <p>Kitöltési határidő: <i>{{$article->filling_deadline}}</i></p>
                @endif
                @if($article->details_url)
                    <a class="chip" href="{{$article->details_url}}">További részletek</a>
                @endif
                @if($article->website_url)
                    <a class="chip" href="{{$article->website_url}}">Honlap</a>
                @endif
                @if($article->registration_url)
                    <a class="chip" href="{{$article->registration_url}}">Regisztráció</a>
                @endif
                @if($article->fill_url)
                    <a class="chip" href="{{$article->fill_url}}">Kitöltés</a>
                @endif
                @if($article->facebook_event_url)
                    <a class="chip" href="{{$article->facebook_event_url}}">Facebook esemény</a>
                @endif
                @can('edit', \App\Models\EpistolaNews::class)
                    <p>({{$article->uploader->name}})</p>
                    <a class="btn-floating waves-effect waves-light grey right"><i class="material-icons">edit</i></a>
                @endcan
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
