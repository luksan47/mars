@can('modify', \App\Models\PrintAccount::class)
<span class="card-title">@lang('print.modify_print_balance')</span>
<blockquote>@lang('print.transaction_descr')</blockquote>
<div class="row">
<form method="POST" action="{{ route('print.modify') }}">
        @csrf
        <div class="input-field col s12 m12 l5">
            @include("utils.select", ['elements' => $users, 'element_id' => 'user_id_modify'])
        </div>
        <div class="input-field col s12 m12 l5">
            <input id="balance" name="balance" type="number" class="validate @error('balance') invalid @enderror" required>
            <label for="balance">@lang('print.balance')</label>
            @error('balance')
            <span class="helper-text" data-error="{{ $message }}"></span>
            @enderror
        </div>
        <div class="input-field col s12 m12 l2">
            <button type="submit" class="btn waves-effect right">@lang('print.add')</button>
        </div>
    </form>
</div>
@endif
