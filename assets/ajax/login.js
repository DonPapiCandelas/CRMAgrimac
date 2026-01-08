$(document).ready(function() {
    $("form").on("submit", function(event) {
        event.preventDefault();

        $.post(getURL() + 'login', $(this).serialize(), function(response) {
            if(response.status) {
                window.location = getURL();
            } else {
                $("form")[0].reset();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.code
                });
            }
        }, 'JSON');
    });
});