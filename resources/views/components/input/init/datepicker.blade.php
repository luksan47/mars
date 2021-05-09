@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datepicker_{{$id}}').datepicker({
                format: '{{$format}}',
                firstDay: 1,
                yearRange: {{$yearRange}},
                showClearBtn: true
            });
        });
    </script>
@endpush