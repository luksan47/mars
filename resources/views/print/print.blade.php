<div class="card">
    <div class="card-header">@lang('print.print_document')</div>
    <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('print.print') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">@lang('print.select_document')</div>
                <div class="col-md-3 text-right">@lang('print.twosided')</div>
                <div class="col-md-3"><input type="checkbox" name="two_sided" id="two_sided" @if (old('two_sided')) checked @endif/> </div>
            </div>
            <div class="row">
                <div class="col-md-6"><input type="file"  name="file_to_upload" id="file_to_upload" required></div>
                <div class="col-md-3 text-right">@lang('print.number_of_copies')</div>
                <div class="col-md-3"><input id="number_of_copies" name="number_of_copies" type="number" min="1" value="{{ old('number_of_copies', '1') }}" required></div>
            </div>

            <div class="row" style="margin-top:10px;margin-bottom:10px;">
                <div class="col-md-5"></div>
                <div class="col-md-2">
                    <input type="submit" class="form-control btn btn-primary" value="@lang('print.print')" />
                </div>
                <div class="col-md-5"></div>
            </div>
        </form>
        <div class="alert alert-info">
            <strong>@lang('general.note'):</strong> @lang('print.pdf_description')
        </div>
    </div>
</div>
