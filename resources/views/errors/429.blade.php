@extends('errors::minimal')

@section('title', __('http_errors.Too Many Requests'))
@section('code', '429')
@section('message', __('http_errors.Too Many Requests'))
