<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-10 offset-sm-1">

            <h2 class="mt-3">Tanulmányok</h2>

            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">Középiskola:</th>
                        <td>{{ $application['school_name'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Középiskola címe:</th>
                        <td>
                            {{ $application['school_country'] ?? '–' }}
                            {{ $application['school_city'] ?? '–' }}
                            <small>
                                {{ $application['school_zip'] ?? '–' }}
                                {{ $application['school_street'] ?? '–' }}
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Érettségi éve:</th>
                        <td>{{ $application['studies_matura_exam_year'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Érettségi átlag:</th>
                        <td>{{ $application['studies_matura_exam_avrage'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Egyetemi szak:</th>
                        <td class="embeding-table">
                            <table class="table embeded-table">
                                <tbody>
                                    @if (isset($application['studies_university_courses']) && $application['studies_university_courses'][0] != '' )
                                        @foreach ($application['studies_university_courses'] ?? [] as $value)
                                           <tr>
                                               <td>
                                                   {{ $value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                –
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Tanulmányi átlag:</th>
                        <td class="embeding-table">
                            <table class="table embeded-table">
                                <tbody>
                                    @if (isset($application['studies_university_studies_avrages']) && $application['studies_university_studies_avrages'][0] != '' )
                                        @foreach ($application['studies_university_studies_avrages'] ?? [] as $key => $value)
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}. félév
                                                </td>
                                                <td>
                                                    {{ $value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                –
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Nyelvvizsga:</th>
                        <td class="embeding-table">
                            <table class="table embeded-table">
                                <tbody>
                                    @if (isset($application['achivements_language_exams']) && $application['achivements_language_exams'][0] != '' )
                                        @foreach ($application['achivements_language_exams'] ?? [] as $value)
                                           <tr>
                                               <td>
                                                   {{ $value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                –
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Verseny:</th>
                        <td class="embeding-table">
                            <table class="table embeded-table">
                                <tbody>
                                    @if (isset($application['achivements_competitions']) && $application['achivements_competitions'][0] != '' )
                                        @foreach ($application['achivements_competitions'] ?? [] as $value)
                                           <tr>
                                               <td>
                                                   {{ $value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                –
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Publikációk:</th>
                        <td class="embeding-table">
                            <table class="table embeded-table">
                                <tbody>
                                    @if (isset($application['achivements_publications']) && $application['achivements_publications'][0] != '' )
                                        @foreach ($application['achivements_publications'] ?? [] as $value)
                                           <tr>
                                               <td>
                                                   {{ $value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                –
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Külföldi tanulmányok:</th>
                        <td class="embeding-table">
                            <table class="table embeded-table">
                                <tbody>
                                    @if (isset($application['achivements_studies_abroad']) && $application['achivements_studies_abroad'][0] != '' )
                                        @foreach ($application['achivements_studies_abroad'] ?? [] as $value)
                                           <tr>
                                               <td>
                                                   {{ $value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                –
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
