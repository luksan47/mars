@extends('layouts.app')

@section('title')
    Jelentkezés
@endsection


@section('content')
    <div class="card">
        <div class="card-content">
            <h6>Jelentkezés státusza: <i>Folyamatban</i></h6>
            <h6>Jelentkezési határidő:
                <i>{{ $deadline->format('Y-m-d H:i') }}</i>
                @if ($deadline_extended)
                    <small class="coli-text text-orange">(Meghosszabbítva)</small>
                @endif
            </h6>
            Hátra van: <i>{{ \Carbon\Carbon::now()->diffInDays($deadline, false) }}</i> nap.

            <blockquote>
                <p>A jelentkezése jelen állapotában még nem látható a felvételiztető bizottság számára! </p>
                <p>A jelentkezése bármikor félbe szakítható, a regisztrációnál megadott e-mail címmel és jelszóval belépve bármikor visszatérhet erre az oldalra, és folytathatja az űrlap kitöltését.</p>
                <p>Miután minden szükséges kérdést megválaszolt és fájlt feltöltött, kérjük, véglegesítse a jelentkezését.</p>
                <p>Kérjük figyeljen a határidőre, mert utána már nem lesz lehetősége véglegesíteni azt.</p>
                <p>Amennyiben bármi kérdése lenne a felvételivel kapcsolatban, kérjük, írjon a <a
                        href="mailto:titkarsag@eotvos.elte.hu">titkarsag@eotvos.elte.hu</a> e-mail címre. Ha technikai
                    probléma adódna, kérjük, jelezze felénk a <a href="mailto:root@eotvos.elte.hu">root@eotvos.elte.hu</a>
                    e-mail címen.</p>
            </blockquote>
            @foreach ($errors->all() as $error)
                <blockquote class="error">{{ $error }}</blockquote>
            @endforeach
        </div>
    </div>
    <nav class="nav-extended">
        <div class="nav-content">
            <ul class="tabs tabs-transparent">
              <li class="tab"><a href="{{route('application', ['page' => 'personal'])}}" class="@yield('personal-active')">Általános információk</a></li>
              <li class="tab"><a href="{{route('application', ['page' => 'educational'])}}" class="@yield('educational-active')">Tanulmányi információk</a></li>
              <li class="tab"><a href="{{route('application', ['page' => 'questions'])}}" class="@yield('questions-active')">Felvételihez kapcsolódó kérdések</a></li>
              <li class="tab"><a href="{{route('application', ['page' => 'files'])}}" class="@yield('files-active')">Fájlok</a></li>
              <li class="tab right"><a href="{{route('application', ['page' => 'finalize'])}}" class="@yield('finalize-active')">Ellenőrzés és véglegesítés</a></li>
            </ul>
        </div>
    </nav>
    @yield('form')


@endsection
