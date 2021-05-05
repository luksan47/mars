@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('mr-and-miss.mr-and-miss')</a>
@endsection

@section('student_council_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content">
            <span class="card-title">@lang('mr-and-miss.vote')</span>
            <p>@lang('mr-and-miss.vote-explanation')</p>
        </div>
        <div class="card-tabs">
          <ul class="tabs tabs-fixed-width">
            <li class="tab"><a @if(!session('activate_custom')) class="active" @endif href="#tab1">{{ $miss_first ? 'miss' : 'mr' }}</a></li>
            <li class="tab"><a href="#tab2">{{ $miss_first ? 'mr' : 'miss' }}</a></li>
            <li class="tab"><a @if(session('activate_custom')) class="active" @endif  href="#tab3">@lang('mr-and-miss.custom')</a></li>
          </ul>
        </div>
        <div class="card-content lighten-4">
          <form action="{{ route('mr_and_miss.vote.save') }}" method="post">
            @csrf
            <div id="tab1">
              @include('student-council.mr-and-miss.votefields', ['genderCheck' => !$miss_first, 'custom' => false])
            </div>
            <div id="tab2">
              @include('student-council.mr-and-miss.votefields', ['genderCheck' => $miss_first, 'custom' => false])
            </div>
            <div id="tab3">
              @include('student-council.mr-and-miss.custom')
            </div>
        </form>
        </div>
      </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>
      $('.input-changer').click(function(event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var id = event.target.dataset.number;
        var rawInput = document.getElementById("raw-" + id);
        var selectInput = document.getElementById("select-ui-" + id);
        rawInput.hidden = !rawInput.hidden;
        selectInput.hidden = !selectInput.hidden;
        event.target.innerHTML = event.target.innerHTML == "border_color" ? "clear_all" : "border_color";
      });
      $('#mr-submit').click(function(event) {
        $('.mr-textarea').each(function () {
          if (this.hidden) {
            this.innerHTML = null
          }
        })

      })
    </script>
    <script>
      $(document).ready(function(){
        $('.tabs').tabs();
      });
    </script>
@endpush