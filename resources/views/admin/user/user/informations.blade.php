<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h1 class="mt-4 mb-4 offset-sm-1">{{ $user['name'] ?? 'Anonymus' }}</h1>

            <table class="table col-sm-10 offset-sm-1">
                <tbody>
                    <tr>
                        <th scope="row">
                            Id:
                        </th>
                        <td>
                            {{ $user['id'] ?? '–' }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            E-mail:
                        </th>
                        <td>
                            {{ $user['email'] ?? '–' }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            E-mail hitelesítve:
                        </th>
                        <td>
                            {{ isset($user['email_verified_at']) ? 'Igen' : 'Nem' }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Role:
                        </th>
                        <td>
                            {{ $user['role'] ?? '–' }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            Regisztrált:
                        </th>
                        <td>
                            {{ $user['created_at'] ?? '–' }}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
