@extends('layouts.app')

@section('title')
<i class="material-icons left">chevron_right</i>@lang('general.report_bug')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('general.report_bug')</span>
                <form method="POST" action="{{ route('reportbug') }}">
                    <div class="row">
                        @csrf
                        <div class="input-field col s12">
                            <textarea id="description" name="description" class="materialize-textarea"></textarea>
                            <label for="description">@lang('general.description')</label>
                        </div>
                    </div>
                    <button type="submit" class="btn-floating btn-large waves-effect right"><i class="large material-icons">send</i></button>
                </form>
            </div>
        </div>
    </div>
    @if($url ?? '')
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('general.successfully_added')</span>
                <blockquote>
                    <a href="{{$url ?? ''}}" target="_blank" >@lang('general.view_issue')</a>
                </blockquote>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection