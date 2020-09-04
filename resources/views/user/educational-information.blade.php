{{-- Educational information --}}
@if($user->hasEducationalInformation())
<div class="card">
    <div class="card-content">
        <div class="card-title">@lang('user.educational_information')</div>
        <table>
            <tbody>
                    <tr>
                        <th scope="row">@lang('info.neptun')</th>
                        <td>{{ $user->educationalInformation->neptun ?? ''}}</td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('info.faculty')</th>
                        <td>
                            <ul>
                                @foreach ($user->faculties as $faculty)
                                <li>{{$faculty->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('info.workshop')</th>
                        <td>
                            <ul>
                                @foreach ($user->workshops as $workshop)
                                <li>{{$workshop->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('info.high_school')</th>
                        <td>{{ $user->educationalInformation->high_school }}</td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('info.year_of_graduation')</th>
                        <td>{{ $user->educationalInformation->year_of_graduation }}</td>
                    </tr>
                    <tr>
                        <th scope="row">@lang('info.year_of_acceptance')</th>
                        <td>{{ $user->educationalInformation->year_of_acceptance }}</td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>
@endif