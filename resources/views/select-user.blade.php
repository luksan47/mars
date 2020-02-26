<!--
<select class="selectpicker autocomplete" data-live-search="true" id="user_id" name="user_id" title="@lang('info.name')">
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</select>
-->
<input type="text" id="autocomplete" class="autocomplete validate" required>
<label for="autocomplete">@lang('info.name')</label>
@section('select-user-js')
$('input.autocomplete').autocomplete({data:
    {
    @foreach ($users as $user)
    "{{ $user->name }}":null, 
    @endforeach
    }
});
@endsection