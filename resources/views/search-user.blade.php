

<select class="selectpicker" data-live-search="true">
    @foreach ($users as $user)
        <option>{{ $user->name }}</option>
    @endforeach 
    
</select>
