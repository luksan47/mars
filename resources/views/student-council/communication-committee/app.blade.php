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
            Epistola Collegii</span>
    </div>
    <div class="col s12 m6">
        <span style="margin:20px;font-size:25px;font-family:'Playfair Display'" class="coli-text text-blue">
            A Választmány hírlevele</span><br>
    </div>
    <div class="col s12 m6">
        @can('send', \App\Models\EpistolaNews::class)
        <a class="btn-floating green right" style="margin-left: 10px" href="{{ route('epistola.send')}}">
            <i class="material-icons">send</i></a>
        <a class="btn-floating grey right" style="margin-left: 10px" href="{{ route('epistola.preview')}}">
            <i class="material-icons">remove_red_eye</i></a>
        @endcan
        @can('create', \App\Models\EpistolaNews::class)
        <a class="btn-floating red right" style="margin-left: 10px" href="{{ route('epistola.new') }}">
            <i class="large material-icons">add</i>
          </a>
        @endcan
    </div>
</div>
<div class="row">
    @forelse ($unsent as $article)
        @if($loop->index % 3 == 0)</div><div class="row">@endif
        <div class="col s12 m6 l6 xl4">
            @include('student-council.communication-committee.epistola', ['article'=> $article])
        </div>
    @empty
        <p style="margin-left:30px">Nincsenek aktuális hírek...</p>
    @endforelse
</div>
@can('edit', \App\Models\EpistolaNews::class)
<hr>
<div class="row">
    @foreach ($sent as $article)
        @if($loop->index % 3 == 0)</div><div class="row">@endif
        <div class="col s12 m6 l6 xl4">
            @include('student-council.communication-committee.epistola', ['article'=> $article])
        </div>
    @endforeach
</div>
@endcan
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
