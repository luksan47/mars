@extends('layouts.app')

@section('content')


<form action="{{ route('applicant.profile.update') }}" method="POST" class="form-horizontal">
    @csrf
    @include('applicant.edit.informations')
    @include('applicant.edit.application')
    @include('applicant.edit.studies')
    @include('applicant.edit.questions')
    @include('applicant.edit.submit')

</form>

@endsection
