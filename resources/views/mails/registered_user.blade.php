

@component('mail::message')
# Tisztelt {{ $recipient['name'] ?? 'Felvételiztető'}}!

A collégium felvételi honlapját a következő belépési adatokkal tudja használni.

@component('mail::panel')
E-mail: &nbsp; {{ $user['email'] }}

Jelszó: &nbsp; {{ $new_password }}
@endcomponent

Bejelentkezési felület: [felveteli.eotvos.elte.hu/login]({{ route('login') }})

A jelszót az első bejelentkezés után kérjük változtassa meg.

Üdvözlettel,<br>
*Eötvös Collegium*
@endcomponent
