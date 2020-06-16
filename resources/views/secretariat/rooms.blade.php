@extends('layouts.app')
@section('title')
<i class="material-icons left">table_view</i>@lang('print.print')
@endsection

@section('content')

<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <span class="card-title">@lang('secretariat.classroom_timetable')</span>
        <div id="timeline" style="height: 180px;"></div>
      </div>
    </div>
  </div>
</div>
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
          [ '012', 'Beginning JavaScript',       new Date(0,0,0,12,0,0),  new Date(0,0,0,13,30,0) ],
          [ '012', 'Intermediate JavaScript',    new Date(0,0,0,14,0,0),  new Date(0,0,0,15,30,0) ],
          [ '013', 'Advanced JavaScript',        new Date(0,0,0,16,0,0),  new Date(0,0,0,17,30,0) ],
          [ '015',   'Beginning Google Charts',    new Date(0,0,0,12,30,0), new Date(0,0,0,14,0,0) ],
          [ '015',   'Intermediate Google Charts', new Date(0,0,0,14,30,0), new Date(0,0,0,16,0,0) ],
          [ '015',   'Advanced Google Charts',     new Date(0,0,0,16,30,0), new Date(0,0,0,18,0,0) ]]);
        
        var options = {
          timeline: { colorByRowLabel: true }
        };

        chart.draw(dataTable, options);
      }
    </script>
@endsection
