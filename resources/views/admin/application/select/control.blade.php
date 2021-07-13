<div class="card mt-4 card-primary">
    <div class="card-content">
        <div class="d-felx col-md-12">

            <h2 class="mt-3 offset-sm-1">Admin panel</h2>

            <table class="table offset-sm-1 col-sm-10">
                <tbody>
                    <tr>
                        <th scope="row">Státusz</th>
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
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="row">


                                @if ( $application['status'] !== App\Applications::STATUS_FINAL )
                                    <div class="col px-0">

                                        <form action="{{ route('admin.application.action.final') }}" method="post">
                                            @csrf
                                            <input type="text" value="{{ $application['id'] }}" name="application_id" required hidden>

                                            <input type="submit" value="Véglegesít" class="btn btn-outline-success form-control font-weight-bolder">

                                        </form>
                                    </div>
                                @endif

                                @if ( $application['status'] !== App\Applications::STATUS_UNFINAL )
                                    <div class="col px-0">

                                        <form action="{{ route('admin.application.action.unfinish') }}" method="post">
                                            @csrf
                                            <input type="text" value="{{ $application['id'] }}" name="application_id" required hidden>

                                            <input type="submit" value="UnVéglegesít" class="btn btn-outline-warning form-control font-weight-bolder">

                                        </form>
                                    </div>
                                @endif

                                @if ( $application['status'] !== App\Applications::STATUS_BANISHED )
                                    <div class="col px-0">

                                        <form action="{{ route('admin.application.action.banish') }}" method="post">
                                            @csrf
                                            <input type="text" value="{{ $application['id'] }}" name="application_id" required hidden>

                                            <input type="submit" value="Letilt" class="btn btn-outline-danger form-control font-weight-bolder">

                                        </form>
                                    </div>
                                @endif

                            </div>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
