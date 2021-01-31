@extends('layouts.app')

@section('title')
<i class="material-icons left">chevron_right</i>@lang('general.home')
@endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('general.you_are_logged_in')</span>
                @if (session('status'))
                <p>{{ session('status') }}</p>
                @endif
                <p>@lang('general.choose_from_menu')</p>
            </div>
        </div>
        @if($information != '' || Auth::user()->hasRoleBase(\App\Models\Role::STUDENT_COUNCIL))
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('general.information')</span>
                <form id="info_form" method="POST" action="{{ route('home.edit') }}">
                    @csrf
                    <p id="info_text">@markdown($information == "" ? "Adj hozzá valamit lenn." : $information)</p>
                    <div id="info_input"></div>
                </form>
            </div>
        </div>
        @endif
        @if(Auth::user()->hasRoleBase(\App\Models\Role::STUDENT_COUNCIL))
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large">
              <i id="edit_btn" class="large material-icons">mode_edit</i>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$("#edit_btn").click(function() {
    if($("#edit_btn").text() == "mode_edit"){
        $("#edit_btn").text("send")
        $("#info_text").text("");
        $("#info_input").html(`<textarea name="text" class="materialize-textarea">{{ $information ?? ""}}</textarea>`);
    }
    else{
        $("#info_form").submit();
    }
});
</script>
@endpush
