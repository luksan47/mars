<div class="card">
    <div class="card-header">@lang('print.printing_account')</div>
    <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('print.modify') }}" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6">
                    <label  class="control-label" for="file_name">@lang('print.document')</label>
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-6">
                    <input type="file"  name="file_to_upload" id="file_to_upload">
                </div>
                <div class="col-md-3">
                    <input type="checkbox"  name="two_sided" id="two_sided"  checked/> @lang('print.twosided')
                </div>
            </div>
            <div class="row" style="margin-top:10px;margin-bottom:10px;">
                <div class="col-md-5"></div>
                <div class="col-md-2"><input type="submit" style="margin-top:10px;" class="form-control btn btn-primary" name="sendValueButton" value="@lang('print.print') " /></div>
                <div class="col-md-5"></div>
            </div>
        </form>
        <div class="alert alert-info">
            <strong>@lang('general.note'):</strong> @lang('print.pdf_description')
        </div>
    </div>
</div>