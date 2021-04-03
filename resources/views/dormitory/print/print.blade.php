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
                <x-input.file l=8 xl=10 id="file_to_upload" accept=".pdf" required text="print.select_document"/>
                <x-input.text l=4 xl=2  id="number_of_copies" type="number" min="1" value="1" required locale="print"/>
                <x-input.checkbox s=8 xl=4 name="two_sided" checked text="print.twosided"/>
                @if($free_pages>0) {{-- only show when user have active free pages --}}
                    <x-input.checkbox s=8 xl=4 name="use_free_pages" text="print.use_free_pages"/>
                    <x-input.button s=4 class="right" text="print.print"/>
                @else
                    <x-input.button s=4 xl=8 class="right" text="print.print"/>
                @endif
            </div>
        </form>
        <div class="row">
            <div class="col l9">
                <blockquote>
                    @if(Cache::has('print.no-paper'))
                        @lang('print.no-paper-reported', ['date' => Cache::get('print.no-paper')])
                    @else
                        @lang('print.no-paper-description')
                    @endif
                </blockquote>
            </div>
            @if(Cache::has('print.no-paper') && Auth::user()->can('handleAny', \App\Models\PrintAccount::class))
                <form method="POST" action="{{ route('print.added_paper') }}">
                    @csrf
                    <x-input.button l=3 class="right coli blue" text="print.added_paper"/>
                </form>
            @else
                <form method="POST" action="{{ route('print.no_paper') }}">
                    @csrf
                    <x-input.button l=3 class="right coli blue" text="print.no_paper" />
                </form>
            @endif
        </div>
    </div>
</div>
