@can('print.modify-free')
<span class="card-title">@lang('print.add_free_pages')</span>
<div class="row">
<form method="POST" action="{{ route('print.free_pages') }}">
    @csrf
    <div class="input-field col s12 m12 l4">
        @include("select-user")
    </div>
    <div class="input-field col s12 m12 l4">
        <input id="free_pages" name="free_pages" type="number" min="0" class="validate" required>
        <label for="free_pages">@lang('print.quantity')</label>
    </div>
    <div class="input-field col s12 m12 l4">
        <button class="btn waves-effect secondary-color" type="submit" >@lang('print.add')</button>
    </div>
</form>
</div>
@endif
