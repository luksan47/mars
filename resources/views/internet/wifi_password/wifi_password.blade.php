<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('internet.wifi_password')</span>
        <blockquote>
            @lang('internet.wifi_password_info')
        </blockquote>
        <table><tbody>
            <tr>
                <td>@lang('internet.wifi_user')</td>
                <td>{{ $internet_access->wifi_username }}</td>
            </tr>
            <tr>
            @if($internet_access->wifi_password != null)
                <td>@lang('internet.wifi_password')</td>
                <td><span onclick="$(this).text('{{ $internet_access->wifi_password }}');"
                                                    style="cursor: pointer;"><button class="waves-effect secondary-color btn-small">@lang('internet.show')</button></span></td>
            @else
                <td colspan="2">@lang('internet.wifi_password_null')</td>
            @endif
            </tr>
        </tbody></table>
        <blockquote>
            <p>@lang('internet.wifi_password_reset_warning')</p>
        </blockquote>
        <form action="{{ route('internet.wifi_password.reset') }}" method="post">
            @csrf
            <button class="btn waves-effect secondary-color" type="submit" name="action">@lang('internet.generate_new_pwd')</button>
        </form>
    </div>
</div>
