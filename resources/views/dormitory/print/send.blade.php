<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.transfer_money')</span>
        <blockquote>
        @lang('print.how_transfer_works')
        </blockquote>
        <form method="POST" action="{{ route('print.transfer-balance') }}">
            @csrf
            <div class="row">
                <x-input.select l=5 id="user_to_send" :elements="$users" text="print.user"/>
                <x-input.text l=5 id="balance" type="number" min="1" required text="print.amount"/>
                <x-input.button l=2 class="right" text="print.send"/>
            </div>
        </form>
    </div>
</div>
