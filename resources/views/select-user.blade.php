<!--
<select class="selectpicker autocomplete" data-live-search="true" id="user_id" name="user_id" title="@lang('info.name')">
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</select>
-->
<select searchable="@lang('general.search')" id="user_id" name="user_id">
  @foreach ($users as $user)
    <option value="{{ $user->id }}">{{ $user->name }}</option>
  @endforeach
</select>
<label for="user_id">@lang('info.name')</label>
