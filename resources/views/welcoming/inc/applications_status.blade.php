@can('isApplicant')

    @switch( \App\Applications::where('user_id',auth()->user()->id)->get(['status'])[0]['status'] )
        @case( \App\Applications::STATUS_FINAL )
            <div class="card col-md-10 offset-sm-1 card-success">
                <div class="card-content px-4 pt-2 ">
                    <span class="h5 card-title">Jelentkezés státusza: <span class="text-success font-weight-bolder">Véglegesítve</span></span>

                    <p>A jelentkezése jelen állapotában látható a felvételiztető bizottságok számára!</p>
                    <p>Kérjük, kövesse a felvételihez tartozó további információkat a <a href="#" class="font-weight-bolder text-primary">Collegium honlapján</a> és <a href="#" class="font-weight-bolder text-primary">Facebook</a> oldadlán.</p>
                    <p>Amennyiben bármi kérdése lenne a felvételivel kapcsolatban, kérjük, írjon a <span class="font-weight-bolder text-primary">titkarsag@eotvos.elte.hu</span> e-mail címre. Ha technikai probléma adódna, kérjük, jelezze felénk a <span class="font-weight-bolder text-primary">root@eotvos.elte.hu</span> e-mail címen.</p>
                </div>
            </div>
        @break
        @case( \App\Applications::STATUS_UNFINAL )
            <div class="card col-md-10 offset-sm-1 card-information">
                <div class="card-content px-4 pt-2 ">
                    <span class="h5 card-title">Jelentkezés státusza: <span class="text-secondary font-weight-bolder">Folyamatban</span></span>

                    <p>A jelentkezése jelen állapotában még nem látható a felvételiztető bizottság számára! A felvételihez szükséges információk a <a href="{{ route('applicant.profile.edit') }}" class="font-weight-bolder text-primary">Jelentkezés</a> menüpont alatt találhatók, a szükséges fájlokat a <a href="{{ route('applicant.uploads') }}" class="font-weight-bolder text-primary">Feltöltés</a> menüpont alatt tudja feltölteni. Miután minden szükséges kérdést megválaszolt és fájlt feltöltött, kérjük, a <a href="{{ route('applicant.final') }}" class="font-weight-bolder text-primary">Véglegesítés</a> menüpont alatt véglegesítse a jelentkezését.</p>
                    <p>Kérjük figyeljen a határidőre, mert utána már nem lesz lehetősége véglegesíteni azt. </p>
                    <p>Amennyiben bármi kérdése lenne a felvételivel kapcsolatban, kérjük, írjon a <span class="font-weight-bolder text-primary">titkarsag@eotvos.elte.hu</span> e-mail címre. Ha technikai probléma adódna, kérjük, jelezze felénk a <span class="font-weight-bolder text-primary">root@eotvos.elte.hu</span> e-mail címen.</p>
                </div>
            </div>
        @break
        @default
            <div class="card col-md-10 offset-sm-1 card-danger">
                <div class="card-content px-4 pt-2 ">
                    <span class="h5 card-title">Jelentkezés státusza: <span class="text-danger font-weight-bolder">Eltávolítva</span></span>

                    <p>A jelentkezése eltávolításra került!</p>
                    <p>Amennyiben úgyérzi, hogy hiba történt azt jelezni tudod felénk a <span class="font-weight-bolder text-primary">root@eotvos.elte.hu</span> e-mail címen.</p>
                </div>
            </div>

    @endswitch

    <div class="card mt-4 card-danger offset-sm-1 col-sm-10">
    <div class="card-content">
        <div class="d-felx   py-4" >

            <h4>Határidő meghosszabbítása</h4>
            <p>
                A felvételi beküldési határideje meghosszabbításra került.<br>
                A pályázat beküldési határideje: <strong class="text-danger">2020. augusztus 15. 23:59 óra</strong>
            </p>
        </div>
    </div>
</div>

@endcan

