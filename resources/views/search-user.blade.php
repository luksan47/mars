

<select class="selectpicker" data-live-search="true" id="user_id" name="user_id">
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach 
    
</select>
