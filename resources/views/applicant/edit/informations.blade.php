<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">
            <h2 class="mt-3 mb-3">Általános információk</h2>

            <div class="form-group form-row">
                <label for="inf_name" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Név:
                </label>
                <input type="text" class="form-control col-sm-7" id="inf_name" name="inf_name" placeholder="..." value="{{ $application['inf_name'] ?? '' }}">
            </div>

            <div class="form-group  form-row">
                <label for="inf_main_email" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Személyes e-mail:
                </label>
                <input type="email" class="form-control col-sm-7" id="inf_main_email" name="inf_main_email" placeholder="..." value="{{ $application['inf_main_email'] ?? '' }}">
            </div>


            <div class="form-group form-row">
                <label for="inf_telephone" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Telefon:
                </label>
                <input type="text" class="form-control col-sm-7" id="inf_telephone" name="inf_telephone" placeholder="..." value="{{ $application['inf_telephone'] ?? '' }}">
            </div>

            {{-- STRAT_OF_ADDRESS --}}
            <div class="form-group form-row">
                <label for="address_country" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Lakhely:
                </label>

                <label for="address_country" class="col-form-label col-sm-3 font-weight-bolder text-justify">
                    Ország:
                </label>

                <input type="text" class="form-control col-sm-4" id="address_country" name="address_country" placeholder="..." value="{{ $application['address_country'] ?? '' }}">

            </div>

            <div class="form-group form-row">
                <label for="address_city" class="col-form-label col-sm-3 offset-sm-4 font-weight-bolder text-justify">
                    Város:
                </label>
                <input type="text" class="form-control col-sm-4" id="address_city" name="address_city" placeholder="..." value="{{ $application['address_city'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="address_zip" class="col-form-label col-sm-3 offset-sm-4 font-weight-bolder text-justify">
                    Irányítószám:
                </label>
                <input type="text" class="form-control col-sm-4" id="address_zip" name="address_zip" placeholder="..." value="{{ $application['address_zip'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="address_street" class="col-form-label col-sm-3 offset-sm-4 font-weight-bolder text-justify">
                    Utca, házszám:
                </label>
                <input type="text" class="form-control col-sm-4" id="address_street" name="address_street" placeholder="..." value="{{ $application['address_street'] ?? '' }}">
            </div>
            {{-- END_OF_ADDRESS --}}

            <div class="form-group form-row">
                <label for="inf_birthdate" class="col-form-label col-sm-2 offset-sm-1 font-weight-bolder text-justify">
                    Születési idő:
                </label>
                <input type="date" class="form-control col-sm-8" id="inf_birthdate" name="inf_birthdate" placeholder="..." value="{{ $application['inf_birthdate'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="inf_mothers_name" class="col-form-label col-sm-2 offset-sm-1 font-weight-bolder text-justify">
                    Anyja neve:
                </label>
                <input type="text" class="form-control col-sm-8" id="inf_mothers_name" name="inf_mothers_name" placeholder="..." value="{{ $application['inf_mothers_name'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="misc_neptun" class="col-form-label col-sm-2 offset-sm-1 font-weight-bolder text-justify">
                    Neptunkód:
                </label>
                <input type="text" class="form-control col-sm-8" id="misc_neptun" name="misc_neptun" placeholder="..." value="{{ $application['misc_neptun'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="misc_caesar_mail" class="col-form-label col-sm-2 offset-sm-1 font-weight-bolder text-justify">
                    Egyetemi e-mail:
                </label>
                <input type="email" class="form-control col-sm-8" id="misc_caesar_mail" name="misc_caesar_mail" pattern=".+elte.hu" placeholder="..." value="{{ $application['misc_caesar_mail'] ?? '' }}">
            </div>

            <div class="bd-callout bd-callout-information col-sm-10 offset-sm-1">
                <p class="text-justify">
                    Az egyetemi email címét az alábbi oldalon történő bejelentkezéssel igényelheti a felvételi értesítőt követő napokban az egyetem részéről e-mailben kiküldött Neptun azonosítóval és jelszóval: <a href="https://ugykezelo.elte.hu/">ugykezelo.elte.hu</a>
                </p>
            </div>
        </div>
    </div>
</div>
