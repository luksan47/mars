@component('mail::message')
    @lang('mail.no_paper')
    <p>@lang('mail.thank_you'),</p>
   {{$userName}}
@endcomponent
