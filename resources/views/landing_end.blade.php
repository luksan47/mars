@extends('layouts.app')
@section('title')
<a href="#!" class="breadcrumb">Eötvös József Collegium - @lang('general.admission')</a>
@endsection

@section('content')
    @include('auth.register', ['user_type' => \App\Models\Role::COLLEGIST])
@endsection