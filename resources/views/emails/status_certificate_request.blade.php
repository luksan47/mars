@component('mail::message')
<h1>@lang('mail.dear') {{ $recipient }}!</h1>
<p>
@lang('mail.status_cert_request', ['user' => $user]) <a href="{{ $url }}">@lang('mail.show')</a>
</p>
<p>@lang('mail.administrators')</p>
@endcomponent