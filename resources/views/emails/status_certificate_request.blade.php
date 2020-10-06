@component('mail::message')
<h1>@lang('mail.dear') {{ $recipient }}!</h1>
<p>
@lang('mail.status_cert_request', ['user' => $user])<br>
</p>
@component('mail::button', ['url' => $url])
@lang('mail.show')
@endcomponent
<p>@lang('mail.administrators')</p>
@endcomponent