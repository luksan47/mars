@can('create', \App\Models\FreePages::class)
<span class="card-title">@lang('print.add_free_pages')</span>
<div class="row">
    <form method="POST" action="{{ route('print.free_pages') }}">
        @csrf
        <div class="input-field col s12 m12 l3">
            @include("utils.select", ['elements' => $users, 'element_id' => 'user_id_free'])
        </div>
        <x-input.text l=3 id="free_pages" type="number" min='1' text="print.quantity" required/>
        <x-input.datepicker l=3 id="deadline" locale="print" year_range=10 required/>
        <x-input.text l=3 id="comment" locale="general" required/>
        <x-input.button class="right" text="print.add"/>
    </form>
@endif</div>
