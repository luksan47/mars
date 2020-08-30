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
                <div class="input-field col s12 m12 l5">
                    <input id="balance" name="balance" type="number" min="1" value="{{ old('balance') }}" required>
                    <label for="balance">@lang('print.amount')</label>
                </div>
                <div class="input-field col s12 m12 l2">
                    <button class="btn waves-effect right" type="submit" style="width:100%">@lang('print.send')</button>
                </div>
            </div>
        </form>
    </div>
</div>