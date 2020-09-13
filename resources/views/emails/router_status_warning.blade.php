@component('mail::message')
<h1>@lang('mail.dear') {{ $recipient->name }}!</h1>
<p>
@lang('router.router_is_down_warning', ['ip' => $router->ip, 'room' => $router->room])
</p>
<p>@lang('mail.administrators')</p>
@endcomponent