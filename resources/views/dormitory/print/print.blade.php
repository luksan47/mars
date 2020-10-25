<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.print_document')</span>
        <blockquote>
            <p>
            @lang('print.pdf_description')
            @lang("print.pdf_maxsize", ['maxsize' => config('print.pdf_size_limit')/1000/1000])
            @lang('print.costs',['one_sided'=>App\Models\PrintAccount::$COST['one_sided'], "two_sided" => env('PRINT_COST_TWOSIDED')])
            </p><p>
            @lang('print.available_money'): <b class="coli-text text-orange"> {{ Auth::user()->printAccount->balance }}</b> HUF.
            @lang('print.upload_money')
            </p>
        </blockquote>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('print.print') }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="file-field input-field col s12 m12 l8 xl10">
                    <div class="btn waves-effect">
                        <span>File</span>
                        <input type="file"id="file_to_upload" name="file_to_upload" accept=".pdf" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path @error('file_to_upload') invalid @enderror" placeholder="@lang('print.select_document')" type="text" disabled>
                        @error('file_to_upload')
                        <span class="helper-text" data-error="{{ $message }}"></span>
                        @enderror
                    </div>
                </div>
                <div class="input-field col s12 m12 l4 xl2">
                    <input id="number_of_copies" name="number_of_copies" type="number" min="1" value="1" required>
                    <label for="number_of_copies">@lang('print.number_of_copies')</label>
                </div>
                <div class="input-field col s8 xl4">
                    <p>
                        <label>
                            <input type="checkbox" name="two_sided" id="two_sided" class="filled-in checkbox-color"  checked/>
                            <span>@lang('print.twosided')</span>
                        </label>
                    </p>
                </div>
                @if($free_pages>0) {{-- only show when user have active free pages --}}
                <div class="input-field col s8 xl4">
                    <p>
                        <label>
                            <input type="checkbox" name="use_free_pages" id="use_free_pages"
                                class="filled-in checkbox-color" />
                            <span>@lang('print.use_free_pages')</span>
                        </label>
                    </p>
                </div>
                <div class="input-field col s4">
                @else
                <div class="input-field col s4 xl8">
                @endif
                    <button class="btn waves-effect right" type="submit">@lang('print.print')</button>
                </div>
            </div>
        </form>
        <div style="margin-right: 0" class="row">
            <form method="POST" action="{{ route('print.no_paper.email') }}">
                @csrf
                    <button class="btn waves-green right" type="submit">@lang('print.no_paper')</button>
            </form>
        </div>
    </div>
</div>
