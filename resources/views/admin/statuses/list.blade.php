@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('admin.user.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.user_management')</a>
<a href="#!" class="breadcrumb">@lang('admin.statuses')</a>
@endsection
@section('admin_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ App\Semester::current()->tag() }}
                </span>
                <table>
                    <tbody>
                        @php
                        $resident_id = App\Role::getObjectIdByName(App\Role::COLLEGIST, 'resident');
                        @endphp
                        @foreach($collegists as $user)
                        <tr>
                            <td>
                                <b><a href="{{ route('admin.user.show', ['id' => $user->id]) }}" class="black-text" >{{ $user->name }}</a></b>
                                @if($user->hasEducationalInformation())
                                <br>{{ $user->educationalInformation->neptun ?? '' }}
                                @endif
                            </td>   
                            <td>
                                <span class="new badge {{ \App\Semester::colorForStatus($user->getStatus()) }}" data-badge-caption="">
                                    @lang("user." . $user->getStatus())
                                </span>
                            </td>
                            <td>
                                @if($user->isActive())
                                <div class="switch">
                                    <label>
                                    @lang('role.extern')
                                    <input type="checkbox" name="resident" onchange="setStatus({{$user->id}}, this.checked)"
                                        @if($user->isResident()) checked @endif 
                                        @can('viewPermissionFor', $user) @else disabled @endcan>
                                    <span class="lever"></span>
                                    @lang('role.resident')
                                    </label>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="">
                                    @include('admin.statuses.edit_buttons', ['user' => $user, 'semester' => App\Semester::current()])
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.user.semesters', ['id' => $user->id]) }}" class="btn-floating coli blue waves-effect right">
                                        <i class="material-icons">event_note</i></a>
                            </td>
                        @endforeach
                        <script>
                            $(document).ready(function(){
                                $('.tooltipped').tooltip();
                            });
                        </script>
                    </tbody>
                </table>
                <script>
                function setStatus(id, isResident){
                    console.log(id, isResident)
                    $.ajax({
                        url: "{{ route('admin.user.set_collegist_type') }}",
                        data: {
                            user_id: id,
                            resident: isResident
                        },
                        type: 'post',
                        dataType: 'json',
                        success: function(data) {
                            M.toast({html: "@lang('general.successful_modification')"});
                        },
                        error: function(data) {
                            window.alert("Something went wrong. Please try again later.")
                        }
                    });
                }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection