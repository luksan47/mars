@extends('errors::minimal')

@section('title', __('http_errors.Unauthorized'))
@section('code', '401')
@section('message', __('http_errors.Unauthorized'))
