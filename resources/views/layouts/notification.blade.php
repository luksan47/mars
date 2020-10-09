@php
$value = Cache::remember($model::cacheKey(), 5, function () use ($model) { return $model::notifications(); });
@endphp
@if ($value != 0)
<span class="new badge">{{ $value }}</span>
@endif