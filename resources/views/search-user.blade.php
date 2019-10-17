

<select class="selectpicker" data-live-search="true" id="user_id" name="user_id" title="@lang('print.user')">
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach 
    
</select>
