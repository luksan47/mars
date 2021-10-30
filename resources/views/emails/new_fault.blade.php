@component('mail::message')
<h1>@lang('mail.dear') {{ $recipient }}!</h1>
<p>
    @if ($reopen === true)
        @lang('faults.new_fault')
    @else
        @lang('faults.reopened_fault')
    @endif
</p>
@lang('faults.details'):
<ul>
    <li>@lang('faults.reporter'): {{ $fault->reporter->name }}</li>
    <li>@lang('faults.location'): {{ $fault->location }}</li>
    <li>@lang('faults.description'): {{ $fault->description }}</li>
</ul>



<p>@lang('mail.administrators')</p>
@endcomponent