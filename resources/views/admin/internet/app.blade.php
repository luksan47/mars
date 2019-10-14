@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('admin.internet.internet_access.internet_access')
        </div>
        <div class="col-md-8">
            @include('admin.internet.mac_addresses.mac_addresses')
        </div>
    </div>
@endsection
