@component('mail::message')
<h1>Kedves {{ $recipent }}!</h1>
Köszönjük, hogy regisztráltál az {{ config('app.name') }} rendszerbe.
Regisztrációdat egy renszergazda hamarosan kezelni fogja, addig is kérjük türelmed.
@endcomponent