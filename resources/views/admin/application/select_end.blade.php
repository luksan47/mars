@extends('layouts.app')

@section('content')

@include('admin.application.select.control')
@include('admin.application.select.user')

@include('applicant.profile.informations')
@include('applicant.profile.application')
@include('applicant.profile.studies')
@include('applicant.profile.questions')
@include('applicant.profile.uploads')

@endsection
