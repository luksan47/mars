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
                    {{-- Change language --}}
                    <div class="col s12 m3">
                        <a class='dropdown-trigger btn' style="width: 100%" href='#' data-target='dropdownLang'>{{ config('app.locales')[App::getLocale()] }}
                            <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id='dropdownLang' class='dropdown-content'>
                            @foreach (config('app.locales') as $code => $name)
                            @if($code != 'hu' && $code != 'en')
                            <li><a href="{{ route('setlocale', $code) }}">{{ $name }}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    {{-- Change reference language: en or hu --}}
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
                <div class="row">
                    <div class="col s12">
                        <blockquote>
                            @lang('localizations.thank_translations'): <i>Szlovicsák Béla, Tóth Regina, Kovács Sára Kata, {{ implode(", ", $contributors) }}</i>!
                        </blockquote>
                    </div>
                    @can('viewAny', App\Models\LocalizationContribution::class)
                    <div class="col s12">
                        <a href="{{ route('localizations.admin') }}" class="btn right waves-effect"> @lang('localizations.manage_translations')</a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @php
    /* Require reference langugage files - except validation.php */
    $reference_files = [
        'en' => array_diff(scandir(base_path('resources/lang/en')), ['..', '.']),
        'hu' => array_diff(scandir(base_path('resources/lang/hu')), ['..', '.'])
    ];
    @endphp
    @if(App::getLocale() != 'hu' && App::getLocale() != 'en')
    @foreach ($reference_files as $lang => $files)
    <div id="{{ $lang }}" class="{{ $lang == 'hu' ? 'hide' : ''}}">
        @foreach ($files as $file)
        @php
        $fname = substr($file, 0, -4); //filename without .php, used as a part of the expression key
        if($fname == 'validation') {
            $expressions_all = require base_path('resources/lang/'.$lang.'/'.$file);
            $expressions = $expressions_all['attributes'];
        } else {
            $expressions = require base_path('resources/lang/'.$lang.'/'.$file);
        }
        @endphp
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="card-title" id="{{ $fname }}">{{ $fname }}</div>
                    @foreach ($expressions as $key => $value)
                    {{-- Not shown if the expression have an ongoing, unapproved change --}}
                    @php
                    $translations = App\Models\LocalizationContribution::where('language', App::getLocale())->where('key',  $fname.'.'.$key);
                    @endphp
                    @if(is_string($value) && $translations->where('approved', false)->count() == 0)
                    <div class="row scale-transition" style="margin:0" name="{{ $fname . '.' . $key }}">
                        <div class="col s5" style="padding: 0.8rem;">
                            {{ $value }}
                        </div>
                        @if($translations->where('approved', true)->count() != 0)
                        <div class="col s6">
                            <textarea id="{{ $lang . '.' . $fname . '.' . $key }}"
                                class="materialize-textarea">@lang($fname.'.'.($fname == 'validation' ? 'attributes.' : '').$key)</textarea> 
                        </div>
                        @else
                        <div class="col s6">
                            <textarea id="{{ $lang . '.' . $fname . '.' . $key }}"
                                class="materialize-textarea"></textarea>
                        </div>
                        @endif
                        <div class="col s1">
                            <button class="btn-floating waves-effect waves-light right" onclick="send('{{ App::getLocale() }}', '{{ $fname.'.'.$key }}', '{{ $lang }}')">
                                <i class="material-icons">send</i>
                            </button>
                        </div>
                    </div>                     
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
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

@push('scripts')
    <script>
        $('.dropdown-trigger').dropdown();

        var config = {
            url : "{{ route('localizations.add') }}",
            success_msg : "@lang('general.successful_modification')",
            error_msg : "@lang('general.failed')"
        }

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
    <script type="text/javascript" src="{{ mix('js/page_based/localizations.js') }}"></script>
@endpush