$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        firstDay: 1,
        yearRange: 50,
        maxDate: today,
    });
});
