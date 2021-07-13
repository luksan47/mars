<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx col-sm-12">
            <h2 class="mt-3 mb-3">Jelentkezési információk</h2>

            <div class="form-group form-row">
                <label for="misc_status" class="col-form-label col-sm-3 offset-sm-1 font-weight-bolder">
                    Milyen státuszra pályázik?
                </label>

                <label for="misc_status_inner" class="col-form-label col-xs-2 offset-sm-1">
                    Bentlakó
                </label>
                <input type="radio" class="col-xs-2" name="misc_status" id="misc_status_inner" value="{{ App\Applications::MEMBER_INNER }}" @if (($application['misc_status'] ?? '') ==  App\Applications::MEMBER_INNER) checked @endif >

                <label for="misc_status_outer" class="col-form-label col-xs-2 offset-sm-1">
                    Bejáró
                </label>
                <input type="radio" class="col-xs-2" name="misc_status" id="misc_status_outer" value="{{ App\Applications::MEMBER_OUTER }}" @if (($application['misc_status'] ?? '') ==  App\Applications::MEMBER_OUTER) checked @endif>
            </div>

            <div class="form-group form-row">
                <label for="misc_workshops" class="col-form-label col-sm-10 offset-sm-1 font-weight-bolder text-justify">
                    Melyik műhelybe szeretne felvételt nyerni? <small><em>(több műhelyet is megjelölhet)</em></small>
                </label>
            </div>
            <div class="form-group form-row">
                <div class="col-sm-10 offset-sm-1">
                    @foreach (App\Permissions::WORKSHOPS as $workshop_code => $workshop_data)
                        <label for="misc_workshops_{{ $workshop_code }}" class="col-form-label col-sm-5 offset-sm-0">
                            {{ $workshop_data['name'] }}
                            <input class="" type="checkbox" name="misc_workshops[]" id="misc_workshops_{{ $workshop_code }}" value="{{ $workshop_code }}" @if( in_array( $workshop_code, $application['misc_workshops'] ?? [] ) ) checked @endif >
                        </label>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
