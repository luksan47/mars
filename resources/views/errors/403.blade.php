@extends('errors::minimal')

@section('title', __('http_errors.Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'http_errors.Forbidden'))
