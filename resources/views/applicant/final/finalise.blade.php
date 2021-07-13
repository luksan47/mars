<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">

            @if ( $application['status'] === App\Applications::STATUS_FINAL )
                <div class="row">
                    <div class="col-sm-10 offset-sm-1">
                        <div class="bd-callout bd-callout-information">
                            <p class="text-justify">
                                A jelentkezése sikeresen véglegesítésre került.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ( $application['status'] === App\Applications::STATUS_UNFINAL )
                <form action="{{ route('applicant.final.send') }}" method="post">
                    @csrf

                    <div class="bd-callout bd-callout-primary col-sm-10 offset-sm-1 col-xs-10 row ">

                        <input type="checkbox" name="terms_of_service" id="terms_of_service" class="col-sm-1" style="max-width:2em" required>
                        <label for="terms_of_service" class="text-justify col-form-label col-sm-11">
                            Kijelentem, hogy a fent közölt adatok a valóságnak megfelelnek. Elolvastam és elfogadom az <a href="https://www.elte.hu/dstore/document/677/ELTE_SZMSZ_6mell_adatkezeles.pdf">ELTE adatkezelési szabályzatát</a>, valamint tudomásul veszem az <a href="http://honlap.eotvos.elte.hu/wp-content/uploads/2016/02/Adatv%C3%A9delmi-t%C3%A1j%C3%A9koztat%C3%B3.pdf">adatkezelési tájékoztatóban</a> foglaltakat. Jelentkezésemmel hozzájárulok, hogy a felvételire való behívásom esetén a nevem megjelenjen a Collegium honlapján.
                            <br><br>
                            A jelentkezés véglegesítése után nem lesz lehetősége már módosítani azt.
                        </label>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Véglegesítés és beküldés" class="btn btn-primary form-control col-sm-10 offset-sm-1" style="font-size:1.5em;">
                    </div>

                </form>
            @endif

            @if ( $application['status'] === App\Applications::STATUS_BANISHED )
                <div class="row">
                    <div class="col-sm-10 offset-sm-1">
                        <div class="bd-callout bd-callout-danger">
                            <p class="text-justify">
                                A jelentkezése eltávolításra került
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
