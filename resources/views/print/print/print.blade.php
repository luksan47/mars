<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.print_document')</span>
        <blockquote>
            @lang('print.pdf_description')
        </blockquote>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('print.print') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="file-field input-field">
                    <div class="btn waves-effect secondary-color">
                        <span>File</span>
                        <input type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" placeholder="@lang('print.select_document')" type="text">
                    </div>
                </div>
                <div class="input-field col s12 m12 l4">
                    <input id="number_of_copies" name="number_of_copies" type="number" min="1" value="1" class="validate" required>
                    <label for="number_of_copies">@lang('print.number_of_copies')</label>
                </div>
                <div class="input-field col s12 m12 l4">
                    <label>
                        <input type="checkbox" name="two_sided" id="two_sided" class="filled-in checkbox-color" />
                        <span>@lang('print.twosided')</span>
                    </label>
                </div>
                <div class="input-field col s12 m12 l4">
                    <button class="btn waves-effect secondary-color" type="submit" >@lang('print.print')</button>
                </div>
            </div>
        </form>
    </div>
</div>