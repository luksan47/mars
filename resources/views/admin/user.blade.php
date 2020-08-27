@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('info.user_data')</div>
                <table>
                    <tbody>
                        <tr>
                            <th scope="row">@lang('info.name')</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        {{-- email --}}
                        <tr>
                            <th scope="row">@lang('registration.email')</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        {{-- Phone number --}}
                        @if($user->hasPersonalInformation())
                        <tr>
                            <th scope="row">@lang('info.phone_number')</th>
                            <td>{{ $user->personalInformation->phone_number }}</td>
                        </tr>
                        @endif
                        {{-- Neptun code, faculties and workshops --}}
                        @if($user->hasEducationalInformation())
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
                        @endif
                    </tbody>
                </table>

                <div class="card-title">@lang('info.more_user_data')</div>
                <table>
                    <tbody>
                        {{-- Other personal information --}}
                        @if($user->hasPersonalInformation())
                            <tr>
                                <th scope="row">@lang('info.place_and_date_of_birth')</th>
                                <td>
                                    {{ $user->personalInformation->place_of_birth }},  {{ $user->personalInformation->date_of_birth }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('info.mothers_name')</th>
                                <td>
                                    {{ $user->personalInformation->mothers_name }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">@lang('info.address')</th>
                                <td>
                                    {{ $user->personalInformation->country }}, <small>{{ $user->personalInformation->county }}</small>
                                    </br>
                                    {{ $user->personalInformation->zip_code }} {{ $user->personalInformation->city }},
                                    <small>{{ $user->personalInformation->street_and_number }} </small>
                                </td>
                            </tr>
                        @endif
                        {{-- Other educational information --}}
                        @if($user->hasEducationalInformation())
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
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection