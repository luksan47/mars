@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('internet.internet_access.internet_access')
        </div>
<!--
        <div class="col-md-8">
            @include('internet.wifi_password.wifi_password')
        </div>
-->
        <div class="col-md-8">
            @include('internet.mac_addresses.mac_addresses')
        </div>
    </div>
    </div>
@endsection
