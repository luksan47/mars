@component('mail::message')
    <h1>@lang('mail.dear') {{ $recipient }}!</h1>
    <p>
        @if ($is_collegist)
            @lang('mail.new_registration_collegist', ['registered_user' => $registered_user])
        @else
            @lang('mail.new_registration_tenant', ['registered_user' => $registered_user])
        @endif
    </p>
    <p>@lang('mail.administrators')</p>
@endcomponent
