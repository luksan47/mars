<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">
            <h2 class="mt-3 mb-3">Tanulmányok</h2>

            <div class="form-group form-row">
                <label for="school_name" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Középiskola:
                </label>
                <input type="text" class="form-control col-sm-7" id="school_name" name="school_name" placeholder="..." value="{{ $application['school_name'] ?? '' }}">
            </div>

            {{-- STRAT_OF_ADDRESS --}}
            <div class="form-group form-row">
                <label for="school_country" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Középiskola címe:
                </label>

                <label for="school_country" class="col-form-label col-sm-3 font-weight-bolder text-justify">
                    Ország:
                </label>

                <input type="text" class="form-control col-sm-4" id="school_country" name="school_country" placeholder="..." value="{{ $application['school_country'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="school_city" class="col-form-label col-sm-3 offset-sm-4 font-weight-bolder text-justify">
                    Város:
                </label>
                <input type="text" class="form-control col-sm-4" id="school_city" name="school_city" placeholder="..." value="{{ $application['school_city'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="school_zip" class="col-form-label col-sm-3 offset-sm-4 font-weight-bolder text-justify">
                    Irányítószám:
                </label>
                <input type="text" class="form-control col-sm-4" id="school_zip" name="school_zip" placeholder="..." value="{{ $application['school_zip'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="school_street" class="col-form-label col-sm-3 offset-sm-4 font-weight-bolder text-justify">
                    Utca, házszám:
                </label>
                <input type="text" class="form-control col-sm-4" id="school_street" name="school_street" placeholder="..." value="{{ $application['school_street'] ?? '' }}">
            </div>
            {{-- END_OF_ADDRESS --}}

            <div class="form-group form-row">
                <label for="studies_matura_exam_year" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Érettségi éve:
                </label>
                <input type="number" min="2000" max="{{ date("Y") }}" step="1" class="form-control col-sm-7" id="studies_matura_exam_year" name="studies_matura_exam_year" placeholder="..." value="{{ $application['studies_matura_exam_year'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="studies_matura_exam_avrage" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Érettségi átlag:
                </label>
                <input type="number" min="1" max="5" step="0.01" class="form-control col-sm-7" id="studies_matura_exam_avrage" name="studies_matura_exam_avrage" placeholder="..." value="{{ $application['studies_matura_exam_avrage'] ?? '' }}">
            </div>

            <div class="form-group form-row">
                <label for="studies_university_courses" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Egyetemi szak:
                </label>

                @for ($i = 0; $i < count($application['studies_university_courses'] ?? [null]); $i++)

                    <input type="text" class="form-control col-sm-6 {{ $i !== 0 ? 'offset-sm-4' : '' }}" id="studies_university_courses" name="studies_university_courses[]" placeholder="..." value="{{ $application['studies_university_courses'][$i] ?? '' }}">

                    @if ( $i + 1 === count($application['studies_university_courses'] ?? [null]) )
                        <input type="button" value="+" class="form-control btn btn-outline-success  col-sm-1 js_plusz_onclick">
                    @else
                        <input type="button" value="-" class="form-control btn btn-outline-danger  col-sm-1 js_minus_onclick">
                    @endif

                @endfor

            </div>



            <div class="form-group form-row">
                <label for="inf_name" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify optional-if-has-semester">
                    Tanulmányi átlag:
                </label>

                @for ($i = 0; $i < count($application['studies_university_studies_avrages'] ?? [null] ); $i++)

                    <label for="studies_university_studies_avrages_{{ $i + 1 }}" class="col-form-label col-sm-2 {{ $i !== 0 ? 'offset-sm-4' : '' }}">{{ $i + 1 }}. félév</label>
                    <input type="number" min="1" step="0.01" class="form-control col-sm-4" id="studies_university_studies_avrages_{{ $i + 1 }}" name="studies_university_studies_avrages[]" placeholder="..." value="{{ $application['studies_university_studies_avrages'][$i] ?? '' }}">

                    @if ( $i + 1 === count($application['studies_university_studies_avrages'] ?? [null]) )
                        <input type="button" value="+" class="form-control btn btn-outline-success  col-sm-1 js_plusz_double_onclick">
                    @else
                        <input type="button" value="-" class="form-control btn btn-outline-danger  col-sm-1 js_minus_double_onclick">
                    @endif

                @endfor

            </div>

            <div class="form-group form-row">
                <label for="achivements_language_exams" class="not-mandatory col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Nyelvvizsga:
                </label>


                @for ($i = 0; $i < count($application['achivements_language_exams'] ?? [null]); $i++)

                    <input type="text" class="form-control col-sm-6 {{ $i !== 0 ? 'offset-sm-4' : '' }}" id="achivements_language_exams" name="achivements_language_exams[]" placeholder="..." value="{{ $application['achivements_language_exams'][$i] ?? '' }}">

                    @if ( $i + 1 === count($application['achivements_language_exams'] ?? [null]) )
                        <input type="button" value="+" class="form-control btn btn-outline-success  col-sm-1 js_plusz_onclick">
                    @else
                        <input type="button" value="-" class="form-control btn btn-outline-danger  col-sm-1 js_minus_onclick">
                    @endif

                @endfor

            </div>

            <div class="form-group form-row">
                <label for="achivements_competitions" class="not-mandatory col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Versenyeredmények:
                </label>

                @for ($i = 0; $i < count($application['achivements_competitions'] ?? [null]); $i++)

                    <input type="text" class="form-control col-sm-6 {{ $i !== 0 ? 'offset-sm-4' : '' }}" id="achivements_competitions" name="achivements_competitions[]" placeholder="..." value="{{ $application['achivements_competitions'][$i] ?? '' }}">

                    @if ( $i + 1 === count($application['achivements_competitions'] ?? [null]) )
                        <input type="button" value="+" class="form-control btn btn-outline-success  col-sm-1 js_plusz_onclick">
                    @else
                        <input type="button" value="-" class="form-control btn btn-outline-danger  col-sm-1 js_minus_onclick">
                    @endif

                @endfor

            </div>

            <div class="form-group form-row ">
                <label for="achivements_publications" class="not-mandatory col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Publikációk:
                </label>
                @for ($i = 0; $i < count($application['achivements_publications'] ?? [null]); $i++)

                    <input type="text" class="form-control col-sm-6 {{ $i !== 0 ? 'offset-sm-4' : '' }}" id="achivements_publications" name="achivements_publications[]" placeholder="..." value="{{ $application['achivements_publications'][$i] ?? '' }}">

                    @if ( $i + 1 === count($application['achivements_publications'] ?? [null]) )
                        <input type="button" value="+" class="form-control btn btn-outline-success  col-sm-1 js_plusz_onclick">
                    @else
                        <input type="button" value="-" class="form-control btn btn-outline-danger  col-sm-1 js_minus_onclick">
                    @endif

                @endfor

            </div>

            <div class="form-group form-row">
                <label for="achivements_studies_abroad" class="not-mandatory col-form-label col-sm-3 offset-sm-1 font-weight-bolder text-justify">
                    Külföldi tanulmányok:
                </label>

                @for ($i = 0; $i < count($application['achivements_studies_abroad'] ?? [null]); $i++)

                    <input type="text" class="form-control col-sm-6 {{ $i !== 0 ? 'offset-sm-4' : '' }}" id="achivements_studies_abroad" name="achivements_studies_abroad[]" placeholder="..." value="{{ $application['achivements_studies_abroad'][$i] ?? '' }}">

                    @if ( $i + 1 === count($application['achivements_studies_abroad'] ?? [null]) )
                        <input type="button" value="+" class="form-control btn btn-outline-success  col-sm-1 js_plusz_onclick">
                    @else
                        <input type="button" value="-" class="form-control btn btn-outline-danger  col-sm-1 js_minus_onclick">
                    @endif

                @endfor
            </div>



        </div>
    </div>
</div>



