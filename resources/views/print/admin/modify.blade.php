@can('print.modify')
<div class="row">
    <form method="POST" action="{{ route('print.modify') }}">
        @csrf
        @include("search-user")
        <input id="balance" name="balance" type="number">
        <button type="submit" class="btn btn-primary">@lang('print.add')</button>
    </form>
</div>
@endif