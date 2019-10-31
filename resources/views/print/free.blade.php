@can('print.modify-free')
    <div class="card">
        <div class="card-header bg-dark text-white">@lang('print.add_free_pages')</div>
        <div class="card-body">
            <form method="POST" action="{{ route('print.free_pages') }}">
                @csrf
                @include("search-user")
                <input id="free_pages" name="free_pages" type="number" value="0">
                <input id="deadline" name="deadline" data-provide="datepicker">
                <button type="submit" class="btn btn-primary">@lang('print.add')</button>
            </form>
        </div>
    </div>
@endif
