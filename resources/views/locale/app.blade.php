@extends('layouts.app')
@section('title')
<i class="material-icons left">translate</i>@lang('locale.locale')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        @foreach($locale['hu'] as $category => $translations)
            <div class="card">
                <div class="card-content">
                    <span class="card-title">@lang('locale.category'): {{ $category }}</span>
                    @foreach($translations as $key => $value)
                        @if(!is_array($value))
                        <div class="row">
                            <div class="col xl3">
                                <p>{{ $key }}</p>
                            </div>
                            <div class="col 10">
                                <p>{{ $value }}</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
