<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">
            <h2 class="mt-3 mb-3">Feltöltések</h2>

            <table class="table col-sm-10 offset-sm-1">
                <tbody>
                    @if ( isset($uploads) && count($uploads) > 0 )
                        @foreach ($uploads as $upload)
                            <tr>
                                <th><a href="{{ $upload['file_path'] }}" target="blank">{{ $upload['file_name'] }}</a></th>
                                <td>
                                    <form action="{{ route('applicant.uploads.delete') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="text" name="id" value="{{ $upload['id'] }}" hidden required>
                                        <input type="submit" value="Törlés" class="form-control btn btn-outline-danger">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                Nincsenek feltöltött fájljaid.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

        </div>
    </div>
</div>
