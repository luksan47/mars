<div class="card mt-4 card-secondary">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">Felhasználó</h2>

            <table class="table col-sm-10 offset-sm-1">
                <tbody>
                    <tr>
                        <th scope="row">User ID:</th>
                        <td>{{ $user['id'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Felhasználó név:</th>
                        <td>{{ $user['name'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email:</th>
                        <td>{{ $user['email'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Megerősítve:</th>
                        <td>{{ isset($user['email_verified_at']) ? 'Igen' : 'Nem' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Regisztráció:</th>
                        <td>{{ $user['created_at'] ?? '–' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
