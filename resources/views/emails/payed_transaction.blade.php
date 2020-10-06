@component('mail::message')
<h1>@lang('mail.dear') {{ $recipent }}!</h1>
<p>
@lang('checkout.transactions_payed'):
</p>
<ul>
@foreach($transactions as $transaction)
<li>
@if(in_array($transaction->type->name, ['NETREG', 'KKT']))
{{ $transaction->type->name }}
@else
{{ $transaction->comment ?? ''}}
@endif
: {{ $transaction->amount }} Ft. 
(@lang('checkout.collected_by'): {{ $transaction->receiver->name }})
</li>
@endforeach
</ul>
@if($additional_message)
<p>
{{ $additional_message }}
</p>
@endif
<p>@lang('mail.administrators')</p>
@endcomponent