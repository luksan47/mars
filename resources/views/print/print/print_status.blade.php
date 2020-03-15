<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.print')</span>
        <blockquote>
        @lang('print.available_money'): {{ Auth::user()->printAccount->balance }} HUF
        </blockquote>
        @include("print.print.free")
    </div>
</div>