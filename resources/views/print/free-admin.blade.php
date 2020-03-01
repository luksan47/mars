@can('print.modify-free')
    <div class="card">
        <div class="card-header bg-dark text-white">@lang('print.handle_free_pages')</div>
        <div class="card-body">
            <form method="POST" action="{{ route('print.free_pages') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        @include("search-user")
                    </div>
                    <div class="col-md-2">
                        <input class="form-control" id="free_pages" name="free_pages" type="number" placeholder="@lang('print.free')" value="{{ old('free_pages') }}">
                    </div>
                    <div class="col-md-2 input-group date" data-provide="datepicker">
                        <input type="text" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" placeholder="@lang('print.deadline')" value="{{ old('deadline') }}" required>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" id="comment" name="comment" type="text" placeholder="@lang('internet.comment')" value="{{ old('comment') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">@lang('print.add')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
