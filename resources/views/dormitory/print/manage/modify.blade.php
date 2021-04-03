@can('modify', \App\Models\PrintAccount::class)
<span class="card-title">@lang('print.modify_print_balance')</span>
<blockquote>@lang('print.transaction_descr')</blockquote>
<div class="row">
<form method="POST" action="{{ route('print.modify') }}">
        @csrf
        <div class="input-field col s12 m12 l5">
            @include("utils.select", ['elements' => $users, 'element_id' => 'user_id_modify'])
        </div>
        <x-input.text l=5 id="balance" type="number" required lang_file="print"/>
        <div class="input-field col s12 m12 l2">
            <x-input.button class="right" text="print.add"/>
        </div>
    </form>
</div>
@endif
