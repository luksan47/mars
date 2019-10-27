@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="thirdFloor card-header">@lang('admin.thirdFloor')</div>
                    <div style="display: none" id="thirdFloor" class="card-body">
                        <table class="table" bgcolor="white">
                            <thead>
                            <tr>
                                <th scope="col">@lang('admin.room')</th>
                                <th scope="col">@lang('admin.bed1')</th>
                                <th scope="col">@lang('admin.bed2')</th>
                                <th scope="col">@lang('admin.bed3')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($rooms as $room)
                                @if($room->floor==3)
                                    <tr>
                                        <th scope="row">{{300+$room->number}}</th>

                                        @if($room->count_beds>0)
                                        @php
                                            $count= 1;
                                        @endphp
                                        @foreach ($students as $student)
                                            @if(300+$room->number==$student->room)
                                                <td>{{$student->first_name}} {{$student->second_name}}<br>
                                                    Start {{$student->start_date}}
                                                    End {{$student->end_date}}
                                                    <button id="{{$student->id}}"
                                                            class="deleteUser btn-sm btn btn-danger">X
                                                    </button>
                                                </td>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @for($count;$count<4;$count++)
                                            <td></td>
                                        @endfor
                                            @endif

                                    </tr>
                                @endif

                            @endforeach


                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="card card-default">
                    <div class="fourthFloor card-header">@lang('admin.fourthFloor')</div>
                    <div style="display: none" id="fourthFloor" class="card-body">
                        <table class="table" bgcolor="white">
                            <thead>
                            <tr>
                                <th scope="col">@lang('admin.room')</th>
                                <th scope="col">@lang('admin.bed1')</th>
                                <th scope="col">@lang('admin.bed2')</th>
                                <th scope="col">@lang('admin.bed3')</th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach ($rooms as $room)
                                @if($room->floor==4)
                                    <tr>
                                        <th scope="row">{{400+$room->number}}</th>
                                        @php
                                            $count= 1;
                                        @endphp
                                        @foreach ($students as $student)
                                            @if(300+$room->number==$student->room)
                                                <td>{{$student->first_name}} {{$student->second_name}}<br>
                                                    Start {{$student->start_date}}
                                                    End {{$student->end_date}}
                                                    <button id="{{$student->id}}" class="deleteUser">X</button>
                                                </td>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @for($count;$count<4;$count++)
                                            <td></td>
                                        @endfor
                                    </tr>
                                @endif

                            @endforeach


                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="room_add card-header">Assign a student</div>
                    <div style="display: none;" id="room_add" class="card-body">
                        <form method="POST" action="{{url('add_user_for_room')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-sm-12 control" for="floor">@lang('admin.select_floor')</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="floor" id="floor">
                                            <option value="" selected disabled>@lang('admin.select_floor')</option>
                                            <option value="3">3rd floor</option>
                                            <option value="4">4th floor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-sm-12 control" for="room">@lang('admin.select_room')</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="room" id="room">
                                            <option value="" selected disabled>@lang('admin.select_room')</option>
                                            @for($index=1;$index<41;$index++)
                                                <option value="{{$index}}">{{$index}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-sm-12 control" for="first_name">@lang('admin.first_name')</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="first_name" id="first_name"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-sm-12 control" for="last_name">@lang('admin.second_name')</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="last_name" id="last_name"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date" class="col-4 col-form-label">@lang('admin.starting_date')</label>
                                <div class="col-10">
                                    <input class="form-control" name="start_date" type="date" value="{{date("Y-m-d")}}"
                                           id="date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date" class="col-4 col-form-label">@lang('admin.finish_date')</label>
                                <div class="col-10">
                                    <input class="form-control" name="end_date" type="date"
                                           value="{{date('Y-m-d', strtotime(date("Y-m-d") . ' +1 day'))}}" id="date">
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <input class="btn btn-primary" type="submit" value="@lang('admin.assign')">
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
<script>
    $(document).ready(function () {

        $('.thirdFloor').click(function () {
            var attr = $(this).attr('name');
            if (typeof attr !== typeof undefined && attr !== false) {
                $('#thirdFloor').attr('style', 'display:none');
                $(this).removeAttr('name');
            } else {
                $('#thirdFloor').removeAttr('style');
                $(this).attr('name', 'close');
            }
        });
        $('.fourthFloor').click(function () {
            var attr = $(this).attr('name');
            if (typeof attr !== typeof undefined && attr !== false) {
                $('#fourthFloor').attr('style', 'display:none');
                $(this).removeAttr('name');
            } else {
                $('#fourthFloor').removeAttr('style');
                $(this).attr('name', 'close');
            }
        })
        $('.room_add').click(function () {
            var attr = $(this).attr('name');
            if (typeof attr !== typeof undefined && attr !== false) {
                $('#room_add').attr('style', 'display:none');
                $(this).removeAttr('name');
            } else {
                $('#room_add').removeAttr('style');
                $(this).attr('name', 'close');
            }
        })
        $('.deleteUser').click(function () {
            var id = $(this).attr('id');
            $.ajax({
                url: '{{url('delete_user_reservation')}}',
                type: 'get',
                data: {id: id},
                success: function (data) {
                    location.reload();
                },
                error: function (e) {
                }
            });
        })
    })
</script>