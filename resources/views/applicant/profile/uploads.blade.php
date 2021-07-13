<div class="card mt-4 no">
    <div class="card-content">
        <div class="d-felx col-md-10 offset-sm-1">

            <h2 class="mt-3">Feltöltött dokumentumok</h2>

            <table class="table">
                <tbody>
                    @if (isset($uploads) && count($uploads) > 0)
                        @foreach ($uploads ?? [] as $upload)
                            <tr>
                                <td>
                                    <a href="{{ url($upload['file_path']) }}">
                                        <b>{{ $upload['file_name'] }}</b>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td>
                            Nincsenek feltöltött fájljaid.
                        </td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
