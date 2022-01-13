@extends('auth.application.app')

@section('submit-active') active @endsection

@section('form')

    @include('auth.application.application')

    @if($user->application?->isReadyToSubmit() ?? false)
        <div class="card">
            <form method="POST" action="{{ route('application.store', ['page' => 'submit']) }}">
                @csrf
                <div class="card-content">
                    <div class="row">
                        <x-input.checkbox id="check_1" text="Kijelentem, hogy a fenti adatok a valóságnak megfelelnek."
                            required />
                        <x-input.checkbox id="check_2"
                            text="Hozzájárulok ahhoz, hogy a felvételire való behívásom esetén a nevem megjelenjen a Collegium honlapján."
                            required />
                        <x-input.checkbox id="check_3"
                            text="Hozzájárulok ahhoz, hogy felvételem esetén az Eötvös Collegium tanulmányi ügyekkel megbízott munkatársa a NEPTUN-ban hozzáférést kapjon a tanulmányaimmal kapcsolatos adatokhoz."
                            required />
                    </div>
                    <blockquote>A jelentkezés véglegesítése után már nem lesz lehetősége módosítani az adatait.</blockquote>
                    <div class="row center-align" style="margin-bottom: 0">
                        <x-input.button text="Véglegesítés és beküldés" />
                    </div>
                </div>
            </form>
        </div>
    @else
    <div class="card">
        <div class="card-content">
            <blockquote>A jelentkezés véglegesítéséhez töltse ki a hiányzó mezőket.</blockquote>
        </div>
    </div>
    @endif

@endsection
