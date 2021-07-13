<div class="card mt-4">
    <div class="card-content">
        <div class="d-flex col-md-4 d-inline-block float-left">

        <img src="{{ asset( $application['profile_picture_path'] ?? 'img/default-avatar.jpg') }}" class="img-fluid">
        </div>
        <div class="d-felx col-md-8 d-inline-block">
            <h1 class="mt-3">{{ $application['inf_name'] ?? '–' }}</h1>
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">Személyes e-mail:</th>
                        <td>{{ $application['inf_main_email'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Egyetemi e-mail:</th>
                        <td>{{ $application['misc_caesar_mail'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Telefon:</th>
                        <td>{{ $application['inf_telephone'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Neptunkód:</th>
                        <td>{{ $application['misc_neptun'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Lakhely:</th>
                        <td>
                            {{ $application['address_country'] ?? '–' }}
                            {{ $application['address_city'] ?? '–' }}
                            <small>
                                {{ $application['address_zip'] ?? '–' }}
                                {{ $application['address_street'] ?? '–' }}
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Születési idő:</th>
                        <td>{{ $application['inf_birthdate'] ?? '–' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Anyja neve:</th>
                        <td>{{ $application['inf_mothers_name'] ?? '–' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
