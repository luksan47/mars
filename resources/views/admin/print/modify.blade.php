@can('print.modify')
<span class="card-title">@lang('print.modify_print_balance')</span>
<div class="row">
<form method="POST" action="{{ route('print.modify') }}">
        @csrf
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <blockquote>{{ $error }}</blockquote>
        @endforeach
        @endif
        <div class="input-field col s12 m12 l5">
            @include("select", ['elements' => $users, 'element_id' => 'user_id_modify'])
        </div>
        <div class="input-field col s12 m12 l5">
            <input id="balance" name="balance" type="number" required>
            <label for="balance">@lang('print.balance')</label>
        </div>
        <div class="input-field col s12 m12 l2">
            <button type="submit" class="btn waves-effect right">@lang('print.add')</button>
        </div>
    </form>
</div>
@endif    