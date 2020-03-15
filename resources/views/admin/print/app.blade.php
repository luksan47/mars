@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="section">
                @include("admin.print.modify")
                </div>
                <div class="divider"></div>
                <div class="section">
                @include("admin.print.free")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection