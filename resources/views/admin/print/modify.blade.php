@can('print.modify')
<span class="card-title">@lang('print.modify_pages')</span>
<div class="row">
<form method="POST" action="{{ route('print.modify') }}">
    @csrf
    <div class="input-field col s12 m12 l5">
        @include("select-user")
    </div>
    <div class="input-field col s12 m12 l5">
        <input id="balance" name="balance" type="number" required>
        <label for="balance">@lang('print.balance')</label>
    </div>
    <div class="input-field col s12 m12 l2">
        <button type="submit" class="btn waves-effect">@lang('print.add')</button>
    </div>
</form>
</div>
@endif