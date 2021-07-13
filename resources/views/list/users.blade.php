@extends('layouts.app')

@section('content')

<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">Felvételiztetők</h2>

            <table class="table col-sm-10 offset-sm-1 striped responsive-table">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th>E-mail</th>

                        @can('isAdmin')

                        <th>Role</th>
                        <th>Control</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td scope="row">
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email}}

                                @foreach ($user['permissions'] as $permission)
                                    <span class="badge badge-pill badge-{{ \App\Permissions::PERMISSIONS[$permission['permission']]['type'] }}">{{ \App\Permissions::PERMISSIONS[$permission['permission']]['name'] }}</span><br>
                                @endforeach
                            </td>


                            @can('isAdmin')
                            <td>
                                {{ $user->role }}
                            </td>
                            <td>
                                <a href="{{ route('admin.users.select',['id'=>$user['id']]) }}"><button class="btn btn-outline-primary">Szerkesztés</button></a>
                            </td>
                            @endcan

                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</div>

@endsection
