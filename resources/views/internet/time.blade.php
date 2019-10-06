@if (Gate::allows('internet.set_date'))
<div class="card">
    <div class="card-header">@lang('general.admin_panel') - @lang('internet.default_time')</div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="form-horizontal" method="POST" action="{{ route('home') }}">
            @csrf
            
            <div class="form-group{{ $errors->has('new_valid_date') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">@lang('internet.validation_date')</label>

                <div class="col-md-6">
                    <div class='input-group date' data-date-format="yyyy.mm.dd.">
                        <input type="text" class="form-control" name="new_valid_date">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">@lang('internet.modify')</button>
                </div>
            </div>
        </form>
        <div class="alert alert-warning">
            <p>@lang('internet.default_time_now_description'): <strong> {{ 42 }} </strong></p>
            <p>@lang('internet.default_time_set_note_description')</p>
        </div>
    </div>
</div>
@endif