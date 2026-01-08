$(document).ready(function() {
    $('#gohome').on('click', function() {
        window.location.href = getURL();
    });

    if(window.location == getURL()) {
        $('#gohome').addClass('active');
    }
});

function getURL() {
    let pathname = window.location.pathname;
    let path = pathname.split('/');

    let url = window.location.protocol + '//' + window.location.hostname + ':39741/' + path[1] + '/';
    return url;
}

function showError(code) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: code
    })
}