<div class="card">
    <div class="card-header">@lang('internet.internet_access')</div>
    <div class="card-body">
        @if($internet_access->has_internet_until > \Carbon\Carbon::now())
            <div class="alert alert-success">
                <p>@lang('internet.has_internet', ['ends' => $internet_access->has_internet_until])</p>
            </div>
        @else
            <div class="alert alert-danger">
                <p>@lang('internet.no_internet')</p>
            </div>
        @endif
    </div>
</div>
