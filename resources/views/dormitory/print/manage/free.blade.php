@can('create', \App\Models\FreePages::class)
<span class="card-title">@lang('print.add_free_pages')</span>
<div class="row">
    <form method="POST" action="{{ route('print.free_pages') }}">
        @csrf
        <div class="input-field col s12 m12 l3">
            @include("utils.select", ['elements' => $users, 'element_id' => 'user_id_free'])
        </div>
        <div class="input-field col s12 m12 l3">
            <input id="free_pages" name="free_pages" type="number" min="1" value="{{ old('free_pages') }}" required
                class="validate @error('free_pages') invalid @enderror">
            <label for="free_pages">@lang('print.quantity')</label>
            @error('free_pages')
            <span class="helper-text" data-error="{{ $message }}"></span>
            @enderror
        </div>
        <div class="input-field col s12 m12 l3" data-provide="datepicker">
            <input type="text" class="datepicker validate @error('deadline') invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline') }}"
                required onfocus="M.Datepicker.getInstance(deadline).open();">
            <label for="deadline">@lang('print.deadline')</label>
            @error('deadline')
            <span class="helper-text" data-error="{{ $message }}"></span>
            @enderror
        </div>
        <div class="input-field col s12 m12 l3">
            <input id="comment" name="comment" type="text" value="{{ old('comment') }}" required>
            <label for="comment">@lang('internet.comment')</label>
        </div>
        <div class="input-field col s12">
            <button class="btn waves-effect right" type="submit">@lang('print.add')</button>
        </div>
    </form>
@endif</div>


@push('scripts')
    <script>
        var tomorrow = new Date();
        tomorrow.setDate(new Date().getDate()+1);
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                firstDay: 1,
                yearRange: 10,
                minDate: tomorrow,
            });
        });
    </script>
@endpush