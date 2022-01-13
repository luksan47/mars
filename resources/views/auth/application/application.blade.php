{{-- All the application's data for finalization and for the admission committes to show --}}
<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s12 xl4">
                @if ($user->profilePicture)
                    <img src="{{ url($user->profilePicture?->path) }}" style="max-width:300px">
                @else
                    TODO
                @endif
            </div>
            <div class="col s12 xl8">
                <div class="card-title">{{ $user->name }}</div>
                <p style="margin-bottom: 5px"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                <p style="margin-bottom: 5px">{{ $user->personalInformation->phone_number }}</p>
                <p style="margin-bottom: 5px">{{ $user->educationalInformation?->programs }}</p>
                <p style="margin-bottom: 5px">
                    @foreach ($user->workshops as $workshop)
                        <span class="new badge {{ $workshop->color() }} scale-transition tag"
                            style="float:none;padding:4px;margin:0 10px 0px 2px;" data-badge-caption="">
                            <nobr>@lang('role.'.$workshop->name) </nobr>
                        </span>
                    @endforeach
                </p>
                <p>
                    @if ($user->isResident())
                        <span class="new badge coli blue tag" style="float:none;padding:4px;margin:0 10px 0px 2px;"
                            data-badge-caption="">
                            @lang('role.resident')
                        </span>
                    @endif
                    @if ($user->isExtern())
                        <span class="new badge coli orange tag" style="float:none;padding:4px;margin:0 10px 0px 2px;"
                            data-badge-caption="">
                            @lang('role.extern')
                        </span>
                    @endif
                </p>

            </div>
            <div class="col s12">
                <table>
                    <tbody>
                        <tr>
                            <th scope="row">@lang('user.place_and_date_of_birth')</th>
                            <td>
                                {{ $user->personalInformation->place_of_birth }}
                                {{ $user->personalInformation->date_of_birth }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('user.mothers_name')</th>
                            <td>
                                {{ $user->personalInformation->mothers_name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('user.address')</th>
                            <td>
                                {{ $user->personalInformation->country }},
                                {{ $user->personalInformation->county }}
                                <br>
                                {{ $user->personalInformation->zip_code }} {{ $user->personalInformation->city }},
                                {{ $user->personalInformation->street_and_number }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('user.high_school')</th>
                            <td>{{ $user->educationalInformation?->high_school }}<br>
                                <small>{{ $user->application?->high_school_address }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('user.neptun')</th>
                            <td>{{ $user->educationalInformation?->neptun }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('user.educational-email')</th>
                            <td>{{ $user->educationalInformation?->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('user.faculty')</th>
                            <td>
                                <ul>
                                    @foreach ($user->faculties as $faculty)
                                        <li>{{ $faculty->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('user.year_of_graduation')</th>
                            <td>{{ $user->educationalInformation?->year_of_graduation }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Érettségi átlaga</th>
                            <td>{{ $user->application?->graduation_average }}</td>
                        </tr>
                        @if ($user->application?->semester_average)
                            <tr>
                                <th scope="row">Előző szemeszterek átlaga</th>
                                <td>
                                    @foreach ($user->application?->semester_average as $key => $avg)
                                        {{ $key + 1 }}. félév: {{ $avg }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        @if ($user->application?->language_exam)
                            <tr>
                                <th scope="row">Nyelvvizsga</th>
                                <td>
                                    @foreach ($user->application?->language_exam as $item)
                                        {{ $item }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        @if ($user->application?->competition)
                            <tr>
                                <th scope="row">Versenyeredmények</th>
                                <td>
                                    @foreach ($user->application?->competition as $item)
                                        {{ $item }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        @if ($user->application?->publication)
                            <tr>
                                <th scope="row">Publikációk</th>
                                <td>
                                    @foreach ($user->application?->publication as $item)
                                        {{ $item }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        @if ($user->application?->foreign_studies)
                            <tr>
                                <th scope="row">Külföldi tanulmányok</th>
                                <td>
                                    @foreach ($user->application?->foreign_studies as $item)
                                        {{ $item }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div style="padding:5px">
                    <p style="font-weight: bold;margin-top:20px">Honnan hallott a Collegiumról?</p>
                    <p>{{ $user->application?->question_1 }}</p>
                    <p style="font-weight: bold;margin-top:20px">Miért kíván a Collegium tagja lenni?</p>
                    <p>{{ $user->application?->question_2 }}</p>
                    <p style="font-weight: bold;margin-top:20px">Tervez-e tovább tanulni a diplomája megszerzése után?
                        Milyen tervei vannak az egyetem után?</p>
                    <p>{{ $user->application?->question_3 }}</p>
                    <p style="font-weight: bold;margin-top:20px">Részt vett-e közéleti tevékenységben? Ha igen, röviden
                        jellemezze!</p>
                    <p>{{ $user->application?->question_4 }}</p>
                    <p style="font-weight: bold;margin-top:20px">Csatolmányok</p>
                    <div style="margin-left:30px">
                        @forelse ($user->application?->files ?? [] as $file)
                            @if (!$loop->first)<div class="divider"></div>@endif
                            <div class="row" style="margin-bottom: 0; padding: 10px">
                                <div class="col" style="margin-top: 5px">
                                    <a href="{{ url($file->path) }}">{{ $file->name }}</a>
                                </div>
                                </form>
                            </div>
                        @empty
                            <p>Még nem töltött fel egy fájlt sem.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
