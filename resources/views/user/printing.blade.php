{{-- Printing --}}
@can('view', $user->printAccount)
<div class="card">
    <div class="card-content">
        <div class="card-title">@lang('print.print')</div>
        <table>
            <tbody>
                <tr>
                    <th scope="row">@lang('print.balance')</th>
                    <td>{{ $user->printAccount->balance }} HUF</td>
                </tr>
                <tr>
                    <th scope="row">@lang('print.free')</th>
                    <td>
                        <ul>
                            @foreach($user->freePages->sortBy('deadline') as $page)
                                <li>
                                <span class="new badge
                                    @if($page->available())
                                        green
                                    @else
                                        red
                                    @endif" data-badge-caption="({{ $page->deadline }})">
                                    {{ $page->amount }}
                                    </span>
                                    <small>{{ $page->lastModifiedBy()->name }}: <i>{{ $page->comment }} </i></small>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th scope="row">@lang('print.number_of_printed_documents')</th>
                    <td>{{ $user->numberOfPrintedDocuments() }}</td>
                </tr>
                <tr>
                    <th scope="row">@lang('print.spent_balance')</th>
                    <td>{{ $user->spentBalance() }} HUF</td>
                </tr>
                <tr>
                    <th scope="row">@lang('print.spent_free_pages')</th>
                    <td>{{ $user->spentFreePages() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endcan
