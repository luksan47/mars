@if (Gate::allows('print.modify'))
    <div class="card">
        <div class="card-header">@lang('print.modify')</div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form method="POST" action="{{ route('print.modify') }}">
                @csrf
                <input id="user_id" name="user_id" type="number">
                <input id="balance" name="balance" type="number">
                <button type="submit" class="btn btn-primary">@lang('print.add')</button>
            </form>
        </div>
    </div>
@endif