<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.print_document')</span>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('print.print') }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="file-field input-field col s12 m12 l8 xl10">
                    <div class="btn waves-effect">
                        <span>File</span>
                        <input type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path" placeholder="@lang('print.select_document')" type="text">
                    </div>
                    <span class="helper-text">@lang('print.pdf_description')</span>
                </div>
                <div class="input-field col s12 m12 l4 xl2">
                    <input id="number_of_copies" name="number_of_copies" type="number" min="1" value="1" required>
                    <label for="number_of_copies">@lang('print.number_of_copies')</label>
                </div>
                <div class="input-field col s12 m12 l8 xl4">
                    <p>
                        <label>
                            <input type="checkbox" name="two_sided" id="two_sided" class="filled-in checkbox-color"  checked/>
                            <span>@lang('print.twosided')</span>
                        </label>
                    </p>
                </div>
                <div class="input-field col s12 m12 l8 xl4">
                    <p>
                        <label>
                            <input type="checkbox" name="use_free_pages" id="use_free_pages"
                                class="filled-in checkbox-color" />
                            <span>@lang('print.use_free_pages')</span>
                        </label>
                    </p>
                </div>
                <div class="input-field col s12 m12 l4">
                    <button class="btn waves-effect right" type="submit">@lang('print.print')</button>
                </div>
            </div>
            <blockquote>
                @if (session('print.status'))
                {{ session('print.status') }}
                @endif
                @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </blockquote>
        </form>
    </div>
</div>