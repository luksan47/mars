<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('print.print')</span>
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
        <table><tbody>
            <tr>
                <td>@lang('print.available_money')</td>
                <td>{{ Auth::user()->printAccount->balance }} HUF</td>
            </tr>
            <tr>
                <td>@lang('print.available_free_pages')</td>
                <td>{{ Auth::user()->printAccount->free_pages }}</td>
            </tr>
        </tbody></table>
    </div>
</div>