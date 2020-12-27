@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('role.communication-committee')</a>
<a href="#!" class="breadcrumb">Epistola Collegii</a>
@endsection
@section('student_council_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <span style="margin:20px;font-size:50px;font-family:'Playfair Display';font-variant: small-caps;" class="coli-text text-orange">
            Epistola Collegii</span><br>
        @can('send', \App\Models\EpistolaNews::class)
        <a class="btn-floating green right" style="margin-left: 10px" href="{{ route('epistola.send')}}"><i class="material-icons">send</i></a>
        <a class="btn-floating grey right" href="{{ route('epistola.preview')}}"><i class="material-icons">remove_red_eye</i></a>
        @endif
        <span style="margin:20px;font-size:25px;font-family:'Playfair Display'" class="coli-text text-blue">
            A Választmány hírlevele</span><br>

    </div>
</div>
<div class="row">
    @php $i = 0; @endphp
    @foreach ($news as $article)
    @if($i%3==0)</div><div class="row">@endif
        <div class="col s12 m6 l6 xl4">
            <div class="card hoverable
                @if($article->shouldBeSent())
                @can('send', \App\Models\EpistolaNews::class)
                    orange lighten-4
                @endcan @endif">
                <div class="card-image" style="overflow-x: auto;overflow-y: hidden;">
                    <img class="materialboxed" id="{{$article->id}}" src="{{ $article->picture_path ?? url('/img/committee-logos/kommbiz.jpg')}}" onerror="standby({{$article->id}})">
                </div>
                <div class="card-content activator">
                    <i class="material-icons float right" style="cursor: pointer">more_vert</i></span>
                    <span class="card-title ">{{$article->title}}</span>
                    <p>{{$article->subtitle}}</p>
                    <p><i>{{$article->date_time}}</i></p>
                    @can('send', \App\Models\EpistolaNews::class)
                    @if($article->valid_until)
                        <p><i @if($article->shouldBeSent()) class="red-text" @endif>Releváns {{$article->valid_until}}-ig.</i></p>
                    @endif
                    @endcan
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">{{$article->title}}<i class="material-icons right">close</i></span>
                    <i>{{$article->date_time}}</i>
                    <p>{{$article->description}}</p>
                    @if($article->registration_deadline)
                        <blockquote>Jelentkezési határidő:<br> <i>{{$article->registration_deadline}}</i></blockquote>
                    @endif
                    @if($article->filling_deadline)
                        <blockquote>Kitöltési határidő:<br><i>{{$article->filling_deadline}}</i></blockquote>
                    @endif
                    @if($article->details_url)
                        <a class="chip" href="{{$article->details_url}}">További részletek</a><br>
                    @endif
                    @if($article->website_url)
                        <a class="chip" href="{{$article->website_url}}">Honlap</a><br>
                    @endif
                    @if($article->registration_url)
                        <a class="chip" href="{{$article->registration_url}}">Regisztráció</a><br>
                    @endif
                    @if($article->fill_url)
                        <a class="chip" href="{{$article->fill_url}}">Kitöltés</a><br>
                    @endif
                    @if($article->facebook_event_url)
                        <a class="chip" href="{{$article->facebook_event_url}}">Facebook esemény</a><br>
                    @endif
                    @can('edit', \App\Models\EpistolaNews::class)
                        <p>({{$article->uploader->name}})</p>
                        <a class="btn-floating waves-effect waves-light grey right" href="{{route('epistola.edit', ['epistola' => $article->id])}}"><i class="material-icons">edit</i></a>
                    @endcan
                </div>
            </div>
        </div>
    @php $i++; @endphp
    @endforeach
</div>
@can('create', \App\Models\EpistolaNews::class)
<div class="fixed-action-btn">
    <a class="btn-floating red" href="{{ route('epistola.new') }}">
      <i class="large material-icons">add</i>
    </a>
</div>
@endif
@endsection

@push('scripts')
<script>
function standby(id) {
    document.getElementById(id).src = "{{ url('/img/committee-logos/kommbiz.jpg') }}"
}
$(document).ready(function(){
    $('.materialboxed').materialbox();
  });
</script>
@endpush
