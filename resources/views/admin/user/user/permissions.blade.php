<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">Engedélyek</h2>

            <table class="table col-sm-10 offset-sm-1">
                <tbody>
                    @foreach ( App\Permissions::PERMISSIONS as $permission_code => $permission_data )
                        <tr>
                            <th scope="row">
                                    {{ $permission_data['name'] }}
                            </th>
                            <td>
                                @if ( [] != array_filter( $permissions->all() ?? [], function($permission) use ($permission_code) { return $permission['permission'] == $permission_code; } ) )
                                    <span class="text-success font-weight-bolder">Engedélyezve</span>
                                @endif
                            </td>
                            <td>
                                @if ( [] != array_filter( $permissions->all() ?? [], function($permission) use ($permission_code) { return $permission['permission'] == $permission_code; } ) )
                                    <form action="{{ route('admin.user.permission.revoke') }}" method="POST">
                                        @csrf

                                        <input type="text" value="{{ $permission_code }}" hidden name="permission" required>
                                        <input type="text" value="{{ $user['id'] }}" hidden name="user_id" required>

                                        <input type="submit" class="btn btn-outline-danger btn-sm form-control" value="Revoke">
                                    </form>
                                @else
                                    <form action="{{ route('admin.user.permission.add') }}" method="POST">
                                        @csrf

                                        <input type="text" value="{{ $permission_code }}" hidden name="permission" required>
                                        <input type="text" value="{{ $user['id'] }}" hidden name="user_id" required>

                                        <input type="submit" class="btn btn-outline-success btn-sm form-control" value="Add">
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
