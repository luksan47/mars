<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-md-10 offset-sm-1">

            <h2 class="mt-3">Jelentkezés</h2>

            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">Státusz</th>
                        <td>
                            @switch( $application['misc_status'] ?? '' )
                                @case( \App\Applications::MEMBER_INNER )
                                    Bentlakó
                                    @break
                                @case( \App\Applications::MEMBER_OUTER )
                                    Bejáró
                                    @break
                                @default
                                    –
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Műhely</th>
                        <td class="embeding-table">
                            <table class="table embeded-table">
                                <tbody>
                                    @if (isset($application['misc_workshops']))
                                        @foreach ($application['misc_workshops'] ?? [] as $workshop_code)
                                        <tr>
                                            <td>
                                                {{ App\Permissions::WORKSHOPS[$workshop_code]['name'] }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                –
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
