<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('internet.internet_access')</span>
        <blockquote>
        @if($internet_access->has_internet_until > \Carbon\Carbon::now())
            @lang('internet.has_internet', ['ends' => $internet_access->has_internet_until])
        @else
            @lang('internet.no_internet')
        @endif
        </blockquote>
    </div>
</div>
