@component('mail::message')
<h1>@lang('mail.dear') {{ $recipent }}!</h1>
<p>
@lang('mail.approved_registration')<br>
</p>
@component('mail::button', ['url' => config('app.url')])
@lang('general.login')
@endcomponent
<p>@lang('mail.administrators')</p>
@endcomponent