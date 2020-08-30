@component('mail::message')
<h1>@lang('mail.dear') {{ $recipient->name }}!</h1>
<p>
@lang('print.changed_balance_descr', ['amount' => $amount, 'balance' => $recipient->printAccount->balance, 'modifier' => $modifier])
</p>
<p>@lang('mail.administrators')</p>
@endcomponent