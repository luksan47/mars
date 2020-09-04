@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('admin.users') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.handle-users')</a>
<a href="#!" class="breadcrumb">{{ $user->name }}</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12">

        <div class="card">
            <div class="card-content">
                <div class="card-title">{{ $user->name }} <small>({{ $user->email }})</small></div>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach($user->roles as $role)
                                    <span class="new badge {{ $role->color() }}" data-badge-caption="">{{ $role->name() }}
                                        @if($role->pivot->object_id)
                                            : {{ $role->object()->name }}
                                        @endif
                                    </span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.permissions.show', $user->id) }}" 
                                        class="btn-floating waves-effect waves-light right" @cannot('view', $user) disabled @endcan>
                                        <i class="material-icons">edit</i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>

        {{-- Internet --}}
        @if($user->hasRole(\App\Role::INTERNET_USER))
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('internet.internet')</div>
                <table>
                    <tbody>
                        <tr>
                            <th scope="row">@lang('internet.internet_access')</th>
                            <td>
                                <span class="new badge @if($user->internetAccess->isActive()) green @else red @endif" data-badge-caption="">
                                    @if($user->internetAccess->has_internet_until != null)
                                        {{ $user->internetAccess->has_internet_until }}
                                    @else
                                        @lang('internet.disabled')
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('internet.wifi_user')</th>
                            <td>{{ $user->internetAccess->wifi_username }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('internet.wifi_password')</th>
                            <td>{{ $user->internetAccess->wifi_password }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('internet.mac_address')</th>
                            <td>
                                <ul>
                                    @foreach ($user->macAddresses as $mac)
                                        <li>
                                        <span class="new badge
                                            @if($mac->state == \App\MacAddress::APPROVED)
                                                green
                                            @elseif($mac->state == \App\MacAddress::REQUESTED)
                                                orange
                                            @else
                                                red
                                            @endif" data-badge-caption="">
                                            {{ $mac->mac_address }}
                                            </span>
                                            <small><i>{{ $mac->comment }} </i></small>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Printing --}}
        @if($user->hasRole(\App\Role::PRINTER))
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('print.print')</div>
                <table>
                    <tbody>
                        <tr>
                            <th scope="row">@lang('print.balance')</th>
                            <td>{{ $user->printAccount->balance }} HUF</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('print.free')</th>
                            <td>
                                <ul>
                                    @foreach($user->freePages->sortBy('deadline') as $page)
                                        <li>
                                        <span class="new badge
                                            @if($page->available())
                                                green
                                            @else
                                                red
                                            @endif" data-badge-caption="({{ $page->deadline }})">
                                            {{ $page->amount }}
                                            </span>
                                            <small>{{ $page->lastModifiedBy()->name }}: <i>{{ $page->comment }} </i></small>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('print.number_of_printed_documents')</th>
                            <td>{{ $user->numberOfPrintedDocuments() }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('print.spent_balance')</th>
                            <td>{{ $user->spentBalance() }} HUF</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('print.spent_free_pages')</th>
                            <td>{{ $user->spentFreePages() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Personal information --}}
        <div class="card">
            <div class="card-content">
                <div class="card-title">@lang('user.personal_information')</div>
                <table>
                    <tbody>
                        <tr>
                            <th scope="row">@lang('registration.email')</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">@lang('info.phone_number')</th>
                            <td>{{ $user->personalInformation->phone_number }}</td>
                        </tr>
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
                                    <br>
                                    {{ $user->personalInformation->zip_code }} {{ $user->personalInformation->city }},
                                    <small>{{ $user->personalInformation->street_and_number }} </small>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
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
    </div>
</div>
@endsection