@extends('layouts.app')


@section('content')
    <header class="masterhead align-middle">
        <div class="masterhead-title">
            Eötvös József Collegium – Felvételi
        </div>
        <div class="align-middle">
        </div>
        <a href="#felveteli">
            <input type="button" style="display: block !important;" class="btn align-middle btn-outline-secondary masterhead-button px-4 py-2" value="Jelentkezés">
        </a>

    </header>
    <div id="felveteli">
        <main class="py-4">
            <div class="container-sm ">
                <div class="row">
                    <div class="col">
                        @include('welcoming.inc.application')
                        @include('welcoming.inc.speach_of_HL')
                        @include('welcoming.inc.the_smart_ones')
                        @include('welcoming.inc.the_elected_ones')
                        @include('welcoming.inc.some_media')
                    </div>
                </div>

            </div>
        </main>
    </div>
@endsection