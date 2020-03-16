@extends('layouts.app')
@section('title')
<i class="material-icons left">wifi</i>@lang('internet.internet')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        @include('internet.internet_access.internet_access')
    </div>
</div>
<div class="row">
    <div class="col s12">
        @include('internet.wifi_password.wifi_password')
    </div>
</div>
<div class="row">
    <div class="col s12">
        @include('internet.mac_addresses.mac_addresses')
    </div>
</div>
@endsection
