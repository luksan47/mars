@extends('layouts.app')
@section('title')
<i class="material-icons left">wifi</i>@lang('internet.internet')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        @include('network.internet.internet_access')
    </div>
    <div class="col s12">
        @include('network.internet.wifi_password')
    </div>
    <div class="col s12">
        @include('network.internet.mac_addresses.app')
    </div>
</div>
@endsection
