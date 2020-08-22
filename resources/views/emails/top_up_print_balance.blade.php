@component('mail::message')
<h1>@lang('mail.dear') {{ $recipient->name }}!</h1>
<p>
@lang('print.topped_up_balance_descr', ['amount' => $amount, 'balance' => $recipient->printAccount->balance])
</p>
@endcomponent