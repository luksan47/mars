@can('print.modify-free')
<div class="row">
    <form method="POST" action="{{ route('print.free_pages') }}">
        @csrf
        @include("search-user")
        <div class="input-field col s12">
            <input id="free_pages" name="free_pages" type="number" value="0" class="validate" required>
            <label for="free_pages">@lang('print.quantity')</label>
        </div>
        <div class="input-field col s12 m12 l4">
            <button class="btn waves-effect secondary-color" type="submit" >@lang('print.add')</button>
        </div>
    </form>
</div>
@endif
