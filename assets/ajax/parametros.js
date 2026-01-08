$(document).ready(function() {

    $('#form-settings-edit').on('submit', function(event) {
        event.preventDefault();
        $.post(getURL() + 'parametros/actualizar', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    });

});