@extends('layouts.app')
@section('title')
<i class="material-icons left">table_view</i>@lang('secretariat.module')
@endsection

@section('content')

<div class="row">
  <div class="col s12 m12 l12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">@lang('secretariat.classroom_timetable')</span>
        <div class="row">
          <div class="input-field col">
              <a href="{{ route('secretariat.course') }}" class="btn waves-effect right" type="submit">@lang('secretariat.create_course')</a>
          </div>
          <div class="input-field col">
              <a href="{{ route('secretariat.rooms.schedule') }}" class="btn waves-effect right" type="submit">@lang('secretariat.reserve')</a>
          </div>
        </div>
        <div class="row">
         <div class="col s12 m12 l12">
            <div id="timeline" style="height: 500px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <script src="{{ mix('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['timeline']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: 'string', id: 'room' });
        dataTable.addColumn({ type: 'string', id: 'course' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([
          @foreach($timetable as $lesson)
            @if($lesson->isToday())
              [ '{{ $lesson->classroom->name }}', '{{ $lesson->course->name }}',  moment('{{ $lesson->time }}').toDate(),  moment('{{ $lesson->time }}').add(90, 'minutes').toDate() ],
            @endif
          @endforeach
        ]);

        var options = {
          timeline: {
            colorByRowLabel: true,
          }
        };

        chart.draw(dataTable, options);
      }
      $(window).resize(function(){
        drawChart();
      });
    </script>
@endsection
