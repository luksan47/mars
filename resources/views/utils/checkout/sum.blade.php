{{-- Input: $transaction, $paymentType  --}}
@php
    $sum = isset($transaction[$paymentType]) ? $transaction[$paymentType]->sum('amount') : 0;
@endphp
<tr>
    <td>@lang('checkout.' . $paymentType)</td>
    <td></td>
    <td class="right"><nobr>{{ number_format($sum, 0, '.', ' ') }} Ft</nobr></td>
</tr>