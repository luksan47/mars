@if (Gate::allows('internet.activate'))
<div class="card">
    <div class="card-header">@lang('general.admin_panel') - @lang('internet.validation')</div>
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
            
            <div class="form-group{{ $errors->has('custom_valid_date') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">@lang('internet.custom_validation_date')</label>
                
                <div class="col-md-6">
                    <div class='input-group date' data-date-format="yyyy.mm.dd.">
                        <input type="text" class="form-control" name="custom_valid_date">
                    </div>
                </div>
            </div>
                                            
            <div class="form-group{{ $errors->has('account') ? ' has-error' : '' }}">
                <label  class="col-md-4 control-label" for="user_select">@lang('user.user')</label>
                <div class="col-md-6">
                    <select class="form-control"  name="account"  id="user_select" required="true">
                        @foreach([] as $user)
                            <option value="{{ $user->id() }}">{{ $user->name() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">@lang('internet.validate')</button>
                </div>
            </div>
        </form>
        
        <div class="alert alert-warning">
            <p>@lang('internet.validation_time_set_admin_description')</p>
            <p>@lang('internet.default_time_set_note_description')</p>
            <p>@lang('internet.default_time_now_description'): <strong> {{ 42 }} </strong></p>
        </div>
    </div>
</div>
@endif