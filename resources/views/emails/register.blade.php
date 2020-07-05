@component('mail::message')
<h1>@lang('mail.dear') {{ $recipent }}!</h1>
<p>
@lang('mail.thank_you_registering', ['app'=> config('app.name')])<br>
@lang('mail.wait_for_approving_registration')
</p>
<p>@lang('mail.administrators')</p>
@endcomponent