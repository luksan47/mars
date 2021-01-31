@can('administrate', $checkout)
<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('checkout.all_gathered_transactions') </span>
        <blockquote>@lang('checkout.all_gathered_transactions_descr')</blockquote>
        <table><tbody>
            @foreach($collected_transactions as $collegist)
              <tr>
                    <td>{{ $collegist->name }}</td>
                    <td>{{ $collegist->transactions_received->sum('amount') }} Ft</td>
                    <td>
                        <form method="POST" action="{{ route($route_base . '.to_checkout') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$collegist->id}}">
                            <button type="submit" class="btn-floating waves-effect right green">
                                <i class="material-icons">payments</i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody></table>
    </div>
</div>
@endcan
