
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
                        <tr>
                            <td>
                                <b>{{ $semester->tag() }}</b>
                            </td>
                            <td>
                                <span class="new badge {{ \App\Semester::colorForStatus($user->getStatusIn($semester)) }}" data-badge-caption="">
                                    {{ $user->getStatusIn($semester) }}
                                </span>
                            </td>
                            <td>
                                <div class="right">
                                    <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::ACTIVE]) }}" class="btn-floating green waves-effect">
                                        <i class="material-icons">rowing</i></a>
                                    <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::INACTIVE]) }}" class="btn-floating grey waves-effect">
                                        <i class="material-icons">power</i></a>
                                    <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::DEACTIVATED]) }}" class="btn-floating red waves-effect">
                                        <i class="material-icons">directions_run</i></a>
                                    <a href="{{ route('admin.user.semesters.update', ['id' => $user->id, 'semester' => $semester->id, 'status' => \App\Semester::PASSIVE]) }}" class="btn-floating waves-effect">
                                        <i class="material-icons">self_improvement</i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <!-- TODO: make above template and use it -->
                        @if(!$semesters->contains(\App\Semester::current()))
                        <tr>
                            <td>
                                {{ \App\Semester::current()->tag() }}
                            </td>
                            <td>
                                {{ \App\Semester::INACTIVE }}
                            </td>
                            <td>
                            </td>
                        </tr>
                        @endif
                        @if(!$semesters->contains(\App\Semester::next()))
                        <tr>
                            <td>
                                {{ \App\Semester::next()->tag() }}
                            </td>
                            <td>
                                {{ \App\Semester::INACTIVE }}
                            </td>
                            <td>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection