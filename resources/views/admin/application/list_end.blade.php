@extends('layouts.app')

@section('content')

<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">Jelentkezések</h2>

            <table class="table col-sm-10 offset-sm-1">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Státusz</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $applications as $application )
                        <tr>
                            <th scope="row">
                                {{ $application['id'] ?? '–' }}
                            </th>
                            <td>
                                {{ $application['inf_name'] ?? 'Anonymous' }}
                            </td>
                            <td>
                                @if ( $application['status'] == App\Applications::STATUS_FINAL )
                                    <span class="text-success font-weight-bolder">Beadva</span>
                                @else
                                    @if ( $application['status'] == App\Applications::STATUS_UNFINAL )
                                        <span class="text-warning font-weight-bolder">Folyamatban</span>
                                    @else
                                        <span class="text-danger font-weight-bolder">Letiltva</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.applications.select',['id'=>$application['id']]) }}"><button class="btn btn-outline-primary form-control">Szerkesztés</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</div>

@endsection
