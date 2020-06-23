@extends('layouts.app')
@section('title')
<i class="material-icons left">rule</i>@lang('general.translate')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('general.help_translate')</div>
                <blockquote>@lang('general.help_translate_info', ['app' => config('app.name')])</blockquote>
                <div class="row">
                    <label class="col s3">
                        <input class="with-gap" name="language" type="radio" checked onclick="change_language('en')" />
                        <span>English</span>
                    </label>
                    <label class="col s3">
                        <input class="with-gap" name="language" type="radio" onclick="change_language('hu')" />
                        <span>Hungarian</span>
                    </label>
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
                    @if(is_string($value))
                    <div class="row" style="margin:0">
                        <div class="col s6" style="padding: 0.8rem;">
                            {{ $value }}
                        </div>
                        <div class="col s6">
                            <textarea name="{{ $fname.'.'.$key }}"
                                class="materialize-textarea">@lang($fname.'.'.$key)</textarea>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <button class="btn-floating btn-large waves-effect waves-light right" type="submit">
                        <i class="material-icons right">send</i>
                    </button>
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
        <form>
            @csrf
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        @foreach ($expressions as $key => $value)
                        @if(is_string($value))
                        <div class="row" style="margin:0">
                            <div class="col s6" style="padding: 0.8rem;">
                                {{ $value }}
                            </div>
                            <div class="col s6">
                                <textarea name="{{ $fname.'.'.$key }}"
                                    class="materialize-textarea">@lang($fname.'.'.$key)</textarea>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <button class="btn-floating btn-large waves-effect waves-light right" type="submit">
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @endforeach
    </div>
</div>
@endsection