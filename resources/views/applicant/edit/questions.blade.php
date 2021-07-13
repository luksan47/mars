<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">
            <h2 class="mt-3 mb-3">Felvételihez kapcsolódó kérdések</h2>

            <div class="form-group">
                <label for="question_why_us" class="offset-sm-1 col-sm-10 font-weight-bolder text-justify">
                    Honnan hallott a Collegiumról, miért kíván az Eötvös Collegium tagja lenni?
                </label>
                <textarea name="question_why_us" id="question_why_us" class="form-control offset-sm-1 col-sm-10" rows="7">{{ $application['question_why_us'] ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="question_plans" class="offset-sm-1 col-sm-10 font-weight-bolder text-justify">
                    Milyen tervei vannak az osztatlan tanárszakos vagy BA / BSc, illetve az MA / MSc diploma megszerzése után?
                </label>
                <textarea name="question_plans" id="question_plans" class="form-control offset-sm-1 col-sm-10" rows="7">{{ $application['question_plans'] ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="question_social" class="offset-sm-1 col-sm-10 font-weight-bolder text-justify">
                    Részt vett-e közéleti tevékenységben? Ha igen, röviden jellemezze! <small><em>(Opcionális)</em></small>
                </label>
                <textarea name="question_social" id="question_social" class="form-control offset-sm-1 col-sm-10" rows="7">{{ $application['question_social'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>
