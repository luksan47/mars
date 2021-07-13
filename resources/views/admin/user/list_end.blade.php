@extends('layouts.app')

@section('content')

<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">Felhasználók</h2>

            <table class="table col-sm-10 offset-sm-1">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">
                                {{ $user['id'] ?? '–' }}
                            </th>
                            <td>
                                {{ $user['name'] ?? '–' }}
                            </td>
                            <td>
                                {{ $user['role'] ?? '–' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.users.select',['id'=>$user['id']]) }}"><button class="btn btn-outline-primary">Szerkesztés</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</div>

@endsection
