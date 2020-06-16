window.today = new Date();
$(document).ready(
    function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $('.sidenav').sidenav();
        $(".dropdown-trigger").dropdown({
            hover: false
        });
    }
);