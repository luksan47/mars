<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.transfer_money')</span>
        <blockquote>
        @lang('print.how_transfer_works')
        </blockquote>
        <form method="POST" action="{{ route('print.transfer-balance') }}">
            @csrf
            <div class="row">
                <div class="input-field col s12 m12 l5">
                    @include("utils.select", ['elements' => $users, 'element_id' => 'user_to_send'])
                </div>
                <x-input.text l=5 id="balance" type="number" min="1" required lang_file="print" lang_key="amount"/>
                <x-input.button l=2 class="right" text="print.send"/>
            </div>
        </form>
    </div>
</div>
