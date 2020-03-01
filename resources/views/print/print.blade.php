<div class="card">
    <div class="card-header">@lang('print.print_document')</div>
    <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('print.print') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="alert alert-info">
                <strong>@lang('general.note'):</strong> @lang('print.pdf_description')
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="inlineFormInput">@lang('print.select_document')</label>
                    <input type="file" class="form-control mb-2" name="file_to_upload" id="file_to_upload" required>
                </div>
                <div class="col-md-2">
                    <label for="inlineFormInput">@lang('print.number_of_copies')</label>
                    <input id="number_of_copies" class="form-control mb-2" name="number_of_copies" type="number" min="1" value="1" required>
                </div>
                <div class="col-md-6">
                    <h3>@lang('print.options')</h3>
                    <div>
                        <label for="inlineFormInput">@lang('print.use_free_pages')</label>
                        <input type="checkbox" name="use_free_pages" id="use_free_pages" checked/>
                    </div>
                    <div>
                        <label for="inlineFormInput">@lang('print.twosided')</label>
                        <input type="checkbox" name="two_sided" id="two_sided"  checked/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <input type="submit" class="form-control btn btn-primary" value="@lang('print.print')" />
                </div>
            </div>
        </form>
    </div>
</div>