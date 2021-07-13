@extends('layouts.app')

@section('content')

    @include('welcoming.inc.applications_status')
    @include('applicant.final.informations')

    @include('applicant.profile.informations')
    @include('applicant.profile.application')
    @include('applicant.profile.studies')
    @include('applicant.profile.questions')
    @include('applicant.profile.uploads')

    @include('applicant.final.finalise')


@endsection
