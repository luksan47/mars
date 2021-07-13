<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-10 offset-sm-1">

            <h2 class="mt-3">Kérdések</h2>

            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <p class="font-weight-bold text-justify">Honnan hallott a Collegiumról, miért kíván az Eötvös Collegium tagja lenni?</p>
                            @if (isset($application['question_why_us']))
                                <p class="text-justify">{{ $application['question_why_us'] }}</p>
                            @else
                                <p class="text-center">–</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="font-weight-bold text-justify">Milyen tervei vannak az osztatlan tanárszakos vagy BA / BSc, illetve az MA / MSc diploma megszerzése után?</p>
                            @if (isset($application['question_plans']))
                                <p class="text-justify">{{ $application['question_plans'] }}</p>
                            @else
                                <p class="text-center">–</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="font-weight-bold text-justify">Részt vett-e közéleti tevékenységben?</p>
                            @if (isset($application['question_social']))
                                <p class="text-justify">{{ $application['question_social'] }}</p>
                            @else
                                <p class="text-center">–</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
