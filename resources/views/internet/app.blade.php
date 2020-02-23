@extends('layouts.app')
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
