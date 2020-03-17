@can('print.modify-free')
<span class="card-title">@lang('print.add_free_pages')</span>
<div class="row">
    <form method="POST" action="{{ route('print.free_pages') }}">
        @csrf
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <blockquote>{{ $error }}</blockquote>
        @endforeach
        @endif
        <div class="input-field col s12 m12 l3">
            @include("select-user")
        </div>
        <div class="input-field col s12 m12 l3">
            <input id="free_pages" name="free_pages" type="number" min="0" value="{{ old('free_pages') }}" required>
            <label for="free_pages">@lang('print.quantity')</label>
        </div>
        <div class="input-field col s12 m12 l3" data-provide="datepicker">
            <input type="text" class="datepicker" id="deadline" name="deadline" value="{{ old('deadline') }}"
                required onfocus="M.Datepicker.getInstance(deadline).open();">
            <label for="deadline">@lang('print.deadline')</label>
            <script>
            $(document).ready(function() {
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    firstDay: 1,
                    yearRange: 10,
                    minDate: today,
                });
            });
            </script>
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