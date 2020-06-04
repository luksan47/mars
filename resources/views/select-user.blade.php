<select searchable="@lang('general.search')" id="user_id" name="user_id">
  @foreach ($users as $user)
  <option value="{{ $user->id }}">{{ $user->name }}</option>
  @endforeach
</select>
<label for="user_id">@lang('info.name')</label>
<script>
  //Initialize materialize select
  var instances;
  $(document).ready(
    function() {
      var elems = document.querySelectorAll('select');
      const options = [
        @foreach ($users as $user)
        { name : '{{ $user->name }}',  value : '{{ $user->id }}'},
        @endforeach
        ]
      instances = M.FormSelect.init(elems, options);
});
</script>