<tr>
<td class="header" style="vertical-align:middle">
<a href="{{ $url }}" style="display: inline-block;">
@switch (trim($slot))
@case('Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@break
@case('Urán')
<img src="{{-- https://uran.eotvos.elte.hu/img/uran_blue.png --}}https://mars.local/img/uran_blue.png" width="60" alt="Urán Logó">
<span class="logo" > {{ config('app.name') }} </span>
@break
@default
{{ $slot }}
@endswitch
</a>
</td>
</tr>
