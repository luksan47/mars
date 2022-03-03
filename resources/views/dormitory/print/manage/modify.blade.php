@can('modify', \App\Models\PrintAccount::class)
<span class="card-title">@lang('print.modify_print_balance')</span>
<blockquote>@lang('print.transaction_descr')</blockquote>
<div class="row">
<form method="POST" action="{{ route('print.modify') }}">
        @csrf
        <x-input.select l=5 id="user_id_modify" text="general.user" :elements="$users" :formatter="function($user) { return $user->uniqueName; }"/>
        <x-input.text l=5 id="balance" type="number" required locale="print"/>
        <x-input.button l=2 class="right" text="print.add"/>
    </form>
</div>
@endif
