
@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('admin.user.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.user_management')</a>
<a href="{{ route('admin.user.statuses') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.statuses')</a>
<a href="#!" class="breadcrumb">{{ $user->name }}</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{ route('admin.user.show', ['id' => $user->id]) }}" class="black-text" >
                        {{ $user->name }}</a>
                </span>
                <table>
                    <tbody>
                        @if(!$semesters->contains(\App\Models\Semester::current()))
                            @include('secretariat.statuses.edit_semester', ['user' => $user, 'semester' => \App\Models\Semester::current()])
                        @endif
                        @foreach ($semesters as $semester)
                            @include('secretariat.statuses.edit_semester', ['user' => $user, 'semester' => $semester])
                        @endforeach
                        <tr><td colspan="3"></td></tr>
                        @if(!$semesters->contains(\App\Models\Semester::next()))
                            @include('secretariat.statuses.edit_semester', ['user' => $user, 'semester' => \App\Models\Semester::next()])
                        @endif
                        <!-- TODO: make above template and use it -->
                        <script>
                            $(document).ready(function(){
                                $('.tooltipped').tooltip();
                            });
                        </script>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
