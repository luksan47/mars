

@component('mail::message')
# Tisztelt {{ $recipient['name'] ?? 'Felvételiző'}}!

Jelentkezését az Eötvös Collegiumba örömmel és köszönettel fogadtuk.

A jelentkezések összesítése után, amennyiben szakmai bizottságunk online szóbeli felvételire hívja meg Önt, nevét megtalálja az [eotvos.elte.hu/felveteli](https://eotvos.elte.hu/felveteli) honlapon elérhetővé tett behívottak listáján (legkésőbb augusztus 18-án 10 óráig).

Üdvözlettel,<br>
*Eötvös Collegium*
@endcomponent
