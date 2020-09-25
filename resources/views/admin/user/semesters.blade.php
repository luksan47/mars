
@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('info.semesters')</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ $user->name }}</span>
                <table>
                    <tbody>
                        @foreach ($semesters as $semester)
                            @include('admin.user.semester', ['user' => $user, 'semester' => $semester])
                        @endforeach
                        <!-- TODO: make above template and use it -->
                        @if(!$semesters->contains(\App\Semester::current()))
                            @include('admin.user.semester', ['user' => $user, 'semester' => \App\Semester::current()])
                        @endif
                        @if(!$semesters->contains(\App\Semester::next()))
                            @include('admin.user.semester', ['user' => $user, 'semester' => \App\Semester::next()])
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection