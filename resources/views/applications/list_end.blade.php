@extends('layouts.app')

@section('content')


<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">Jelentkezések – {{ $workshop_name }}</h2>

            <table class="table col-sm-10 offset-sm-1">
                <tbody>
                    @if (isset($applications) && count($applications) > 0)
                        @foreach ( $applications as $application )
                            <tr class="">
                                <th scope="row" class="sm-col-5" style="max-width: 4em; min-width: 2em; ">
                                    <img src="{{ asset($application['profile_picture_path'] ?? 'img/default-avatar.jpg') }}" class="img-fluid d-block" style="min-width: 2em;">
                                </th>
                                <th class="align-middle" >
                                    {{ $application['inf_name'] ?? 'Anonymous' }}
                                </th>
                                <td class="align-middle">
                                    <a href="{{ route('user.applications.select',['id'=>$application['id']]) }}"><button class="btn btn-outline-primary form-control">Megtekintés</button></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                Nincs még beküldött jelentkezés ebbe a műhelybe.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>


        </div>
    </div>
</div>

@endsection
