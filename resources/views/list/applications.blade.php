@extends('layouts.app')

@section('content')


<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">{{ $title ?? 'Jelentkezések' }}</h2>

            <table class="table col-sm-10 offset-sm-1">
                <tbody>
                    @if (isset($applications) && count($applications) > 0)
                        @foreach ( $applications as $application )
                            <tr class="">
                                <th scope="row" class="sm-col-5" style="max-width: 4em; min-width: 2em; ">
                                    <img src="{{ asset($application['profile_picture_path'] ?? 'img/default-avatar.jpg') }}" class="img-fluid d-block" style="min-width: 2em;">
                                </th>
                                <td class="align-middle" >
                                    <h4>
                                        {{  $application['inf_name'] ?? 'Anonymous' }}
                                    </h4>
                                    @switch($application['misc_status'])
                                        @case( \App\Models\Applications::MEMBER_INNER )
                                            <span class="badge badge-warning">Bentlakó</span>
                                            @break
                                        @case( \App\Models\Applications::MEMBER_OUTER )
                                            <span class="badge badge-info">Bejáró</span>
                                            @break
                                    @endswitch

                                    @foreach ($application['misc_workshops'] ?? [] as $workshop_code)
                                        <br><span class="badge badge-pill {{ (\App\Models\Permissions::WORKSHOPS[$workshop_code]['type'] == \App\Models\Permissions::WORKSHOP_TYPE_DOGESZ) ? 'badge-primary' : 'badge-secondary' }}">{{ \App\Models\Permissions::WORKSHOPS[$workshop_code]['name'] }}</span>
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('user.applications.select',['id'=>$application['id']]) }}"><button class="btn btn-outline-primary form-control">Megtekintés</button></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                Nincs még beküldött jelentkezés.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>


        </div>
    </div>
</div>

@endsection
