<div class="card">
    <div class="card-header">@lang('internet.wifi_password')</div>
    <div class="card-body">
        <div class="alert alert-info">
            <p>@lang('internet.wifi_password_info')</p>
        </div>

        @if($internet_access->wifi_password != null)
            <p>@lang('internet.wifi_user'): {{--  TODO: show wifi username --}}
                <br/>
                @lang('internet.wifi_password'): <i><span onclick="$(this).text('{{ $internet_access->wifi_password }}');"
                                                       style="cursor: pointer;">@lang('internet.show')</span></i></p>
        @else
            <p>@lang('internet.wifi_password_null')</p>
        @endif

        <div class="alert alert-danger">
            <form action="{{ route('internet.wifi_password.reset') }}" method="post">
                @csrf
                <p>@lang('internet.wifi_password_reset_warning')</p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="confirm" id="confirm" value="yes">
                    <label class="form-check-label" for="confirm">Nem baj</label>
                    <button type="submit" class="btn btn-danger">Új jelszó generálása</button>
                </div>
            </form>
        </div>
    </div>
</div>
