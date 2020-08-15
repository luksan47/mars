@extends('layouts.app')
@section('title')
<i class="material-icons left">translate</i>@lang('localizations.translate')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('localizations.help_translate')</div>
                <blockquote>@lang('localizations.help_translate_info', ['app' => config('app.name')])</blockquote>
                <div class="row">
                    <div class="col s12 m3">
                        <a class='dropdown-trigger btn' style="width: 100%" href='#' data-target='dropdownLang'>@lang('localizations.language')
                            <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id='dropdownLang' class='dropdown-content'>
                            @foreach (config('app.locales') as $code => $name)
                            <li><a href="{{ route('setlocale', $code) }}">{{ $name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col s6 m3"><i class="right">@lang('localizations.reference_language'):</i></div>
                    <div class="col s6">
                        <label>
                            <input class="with-gap" name="language" type="radio" checked onclick="change_language('en')" />
                            <span>English</span>
                        </label>
                        <br>
                        <label>
                            <input class="with-gap" name="language" type="radio" onclick="change_language('hu')" />
                            <span>Hungarian</span>
                        </label>
                    </div>
                </div>
                <script>
                    function change_language(language){
                    if(language=="hu"){
                        document.getElementById("hu").classList.remove("hide");
                        document.getElementById("en").classList.add("hide");
                    }
                    if(language=="en"){
                        document.getElementById("en").classList.remove("hide");
                        document.getElementById("hu").classList.add("hide");
                    }
                    //set textarea heights
                    ($('textarea')).each(function(index, elem){
                        elem.style.height = elem.scrollHeight+'px'; 
                    });
                }
                </script>
            </div>
        </div>
    </div>
    @php
    $files_en = array_diff(scandir(base_path('resources/lang/en')), ['..', '.', 'validation.php']);
    $files_hu = array_diff(scandir(base_path('resources/lang/hu')), ['..', '.', 'validation.php']);
    @endphp
    @if(App::getLocale() != 'hu' && App::getLocale() != 'en')
    <div id="en">
        @foreach ($files_en as $file)
        @php
        $fname = substr($file, 0, -4);
        $expressions = require base_path('resources/lang/en/'.$file);
        @endphp
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    @foreach ($expressions as $key => $value)
                    @php
                    $duplicate = App\LocalizationContribution::where('language', App::getLocale())->where('key',  $fname.'.'.$key)->first();
                    @endphp
                    @if(is_string($value) && ($duplicate == null || $duplicate->approved))
                    <form method="POST" action="{{ route('localizations.add') }}">
                        @csrf
                        <input type="hidden" name="language" value="{{ App::getLocale() }}">
                        <div class="row" style="margin:0">
                            <div class="col s5" style="padding: 0.8rem;">
                                {{ $value }}
                            </div>
                            <div class="col s6">
                                <input type="hidden" name="key" value="{{ $fname.'.'.$key }}">
                                <textarea name="value"
                                    class="materialize-textarea">@lang($fname.'.'.$key)</textarea>
                            </div>
                            <div class="col s1">
                                <button class="btn-floating waves-effect waves-light right" type="submit">
                                    <i class="material-icons">send</i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div id="hu" class="hide">
        @foreach ($files_hu as $file)
        @php
        $fname = substr($file, 0, -4);
        $expressions = require base_path('resources/lang/hu/'.$file);
        @endphp
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    @foreach ($expressions as $key => $value)
                    @php
                    $duplicate = App\LocalizationContribution::where('language', App::getLocale())->where('key',  $fname.'.'.$key)->first();
                    @endphp
                    @if(is_string($value) && ($duplicate == null || $duplicate->approved))
                    <form method="POST" action="{{ route('localizations.add') }}">
                        @csrf
                        <input type="hidden" name="language" value="{{ App::getLocale() }}">
                        <div class="row" style="margin:0">
                            <div class="col s5" style="padding: 0.8rem;">
                                {{ $value }}
                            </div>
                            <div class="col s6">
                                <input type="hidden" name="key" value="{{ $fname.'.'.$key }}">
                                <textarea name="value"
                                    class="materialize-textarea">@lang($fname.'.'.$key)</textarea>
                            </div>
                            <div class="col s1">
                                <button class="btn-floating waves-effect waves-light right" type="submit">
                                    <i class="material-icons">send</i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <blockquote class="error">@lang('localizations.change_not_hu_en')</blockquote>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection