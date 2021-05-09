@push('scripts')
    <script>
        //Initialize materialize select
        var instances;
        $(document).ready(
        function() {
            var elems = $('#{{ $id }}');
            const options = [
            @foreach ($elements as $element)
                { name : '{{ $element->name ?? $element }}',  value : '{{ $element->id ?? $element }}'},
            @endforeach
            ];
            instances = M.FormSelect.init(elems, options);
        });
  </script>
@endpush