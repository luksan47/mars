@component('mail::message')
    <h1>@lang('mail.dear') {{ $recipient }}!</h1>
    <p>
        @lang('mail.no_paper', ['reporter' => $reporter])
    </p>
    <p>@lang('mail.administrators')</p>
@endcomponent
