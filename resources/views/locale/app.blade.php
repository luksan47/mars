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
                                @if($code != 'hu')
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <!-- TODO: make it do something -->
                    <!-- <button class="btn waves-effect right" type="submit">@lang('locale.send')</button> -->
                </div>
            </div>
        </div>
        <div id="contents">
            @foreach($locale as $language => $locales)
                @if($language != 'hu')
                <div id="{{ $language }}-block" @if($language != 'en') hidden @endif>
                    @foreach($locale['hu'] as $category => $translations)
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">@lang('locale.category'): {{ $category }}</span>
                                @foreach($translations as $key => $value)
                                    @if(!is_array($value))
                                    <div class="row">
                                        <div class="col s5 m3">
                                            <p>{{ $value }}</p>
                                        </div>
                                        <div class="col s7 m9">
                                            <input id="translation-{{ $language }}-{{ $key }}" name="translation-{{ $language }}-{{ $key }}" type="text"
                                                @if(array_key_exists($category, $locales) && array_key_exists($key, $locales[$category]))
                                                    value="{{ $locales[$category][$key] }}"
                                                @endif >
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
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
