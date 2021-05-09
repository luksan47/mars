@push('scripts')
    <script>
        $(document).ready(function() {
            $('.timepicker').timepicker({
                showClearBtn: true,
                twelveHour: false,
            });
        });
    </script>
@endpush