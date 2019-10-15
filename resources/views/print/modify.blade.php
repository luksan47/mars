@if (Gate::allows('print.modify'))
    <div class="card">
        <div class="card-header">@lang('print.modify')</div>
        <div class="card-body">
            <form method="POST" action="{{ route('print.modify') }}">
                @csrf
                @include("search-user")
                <input id="balance" name="balance" type="number">
                <button type="submit" class="btn btn-primary">@lang('print.add')</button>
            </form>
        </div>
    </div>
@endif