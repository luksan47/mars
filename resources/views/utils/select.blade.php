{{-- In order to use this blade, we need to pass an $elements array with id and name, and UID for the page. $required is optional --}}
@php
  $elements = $elements->sortBy('name')
@endphp
<select searchable="@lang('general.search')" id="{{ $element_id }}" name="{{ $element_id }}" 
  @if($required ?? false) required @endif>
  <option value="" disabled selected>@lang('general.choose_option')</option>
  @foreach ($elements as $element)
  <option value="{{ $element->id }}">{{ $element->name }}</option>
  @endforeach
</select>
<label for="{{ $element_id }}">@lang('info.name')</label>
@error($element_id)
<span class="helper-text" data-error="{{ $message }}"></span>
@enderror
<script>
  //Initialize materialize select
  var instances;
  $(document).ready(
    function() {
      var elems = $('#{{ $element_id }}');
      const options = [
        @foreach ($elements as $element)
        { name : '{{ $element->name }}',  value : '{{ $element->id }}'},
        @endforeach
        ]
      instances = M.FormSelect.init(elems, options);
});
</script>