@extends('layouts.app')
@section('title')
<i class="material-icons left">translate</i>@lang('locale.locale')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col xl2">
                        <select id="locale-select" class="dropdown-content">
                            @foreach (config('app.locales') as $code => $name)
                                <option value="{{ $code }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn waves-effect right" type="submit">@lang('locale.send')</button>
                </div>
            </div>
        </div>
        <div id="contents">
            @foreach($locale as $language => $locales)
                <div id="{{ $language }}-block" @if($language != 'en') hidden @endif>
                    @foreach($locales as $category => $translations)
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">@lang('locale.category'): {{ $category }}</span>
                                @foreach($translations as $key => $value)
                                    @if(!is_array($value))
                                    <div class="row">
                                        <div class="col s5 m3">
                                            <p>{{ $key }}</p>
                                        </div>
                                        <div class="col s7 m9">
                                            <input id="balance" name="balance" type="text" value="{{ $value }}">
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    //Initialize materialize select
    var selected = 'en';
    var instances;
    $(document).ready(function() {
        var elems = $('#locale-select');
        const options = []
        instances = M.FormSelect.init(elems, options);
        $( "#locale-select" ).change(function(event) {
            var new_locale = event.target.value;
            document.getElementById(new_locale + '-block').removeAttribute('hidden');
            document.getElementById(selected + '-block').setAttribute('hidden', true);
            selected = new_locale;
        });
    });
</script>

@endsection
