@can('print.modify')
    <span class="card-title">@lang('print.modify_pages')</span>
    <div class="row">
    <form method="POST" action="{{ route('print.modify') }}">
        @csrf
        <div class="input-field col s12 m12 l4">
            @include("select-user")
        </div>
        <div class="input-field col s12 m12 l4">
            <input id="balance" name="balance" type="number" required>
            <label for="balance">@lang('print.balance')</label>
        </div>
        <div class="input-field col s12 m12 l4">
            <button type="submit" class="btn btn-primary right">@lang('print.add')</button>
        </div>
    </form>
    </div>
@endif