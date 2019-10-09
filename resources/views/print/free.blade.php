@if (Gate::allows('print.modify'))
    <div class="card">
        <div class="card-header">@lang('print.add_free_pages')</div>
        <div class="card-body">
            <form method="POST" action="{{ route('print.free_pages') }}">
                @csrf
                @include("utils.search-user")
                <input id="free_pages" name="free_pages" type="number" value="0">
                <button type="submit" class="btn btn-primary">@lang('print.add')</button>
            </form>
        </div>
    </div>
@endif
