<!--
<select class="selectpicker autocomplete" data-live-search="true" id="user_id" name="user_id" title="@lang('info.name')">
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</select>
-->
<input type="text" id="user_id" name="user_id" class="autocomplete" required>
<label for="user_id">@lang('info.name')</label>
<script>
$(document).ready(
    $('input.autocomplete').autocomplete({data:
        {
        @foreach ($users as $user)
        "{{ $user->name }}":null, 
        @endforeach
        }
    });
)
@endsection