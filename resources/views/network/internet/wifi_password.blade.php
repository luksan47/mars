<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('internet.wifi_password')</span>
        <blockquote>
            @lang('internet.wifi_password_info')
        </blockquote>
        <table>
            <tbody>
                <tr>
                    <td>@lang('internet.wifi_user')</td>
                    <td class="right" style="font-family: Monospace;">{{ $internet_access->wifi_username }}</td>
                </tr>
                <tr>
                    @if($internet_access->wifi_password != null)
                    <td>@lang('internet.wifi_password')</td>
                    <td class="right"><span id="pw"
                            style="cursor: pointer; font-family: Monospace;">
                            <button class="waves-effect btn-small">@lang('internet.show')</button></span>
                    </td>
                    @else
                    <td colspan="2">@lang('internet.wifi_password_null')</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col s12 m12 l12 xl8">
                <blockquote>
                    <p>@lang('internet.wifi_password_reset_warning')</p>
                </blockquote>
            </div>
            <div class="input-field col s12 m12 l12 xl4">
                <form action="{{ route('internet.wifi_password.reset') }}" method="post">
                    @csrf
                    <x-input.button class="right" id="action" text="internet.generate_new_pwd"/>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    document.getElementById("pw").addEventListener("click", function() {
        $(this).text('{{ $internet_access->wifi_password }}');
        var copyText = document.getElementById("pw");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        M.toast({html: '<span class="white-text">@lang("internet.copied")</span>'});
    });
});
</script>
@endpush
