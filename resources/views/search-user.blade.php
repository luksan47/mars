<!--
<select class="selectpicker" data-live-search="true" id="user_id" name="user_id" title="@lang('print.user')">
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</select>
-->
<div class="row">
    <div class="col s12">
        <div class="row">
            <div class="input-field col s12">
                <input type="text" id="user_id" name="user_id" class="autocomplete">
                <label for="user_id">@lang('info.name')</label>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('input.autocomplete').autocomplete({
        data: {
        @foreach ($users as $user)
            "{{ $user->id }}": "{{ $user->name }}",
        @endforeach
        },
    });
});
</script>