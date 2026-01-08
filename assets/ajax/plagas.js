var table;

$(document).ready(function() {
    if($('table#plagas').length) {
        listar();
    }

    $('#btnAddPlaga').on('click', function(e) {
        e.preventDefault();
        $("#modal-addPlaga").modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        });
    });

    $('#form-addPlaga').on('submit', function(e) {
        e.preventDefault();
        
        $.post(getURL() + 'plagas/agregar', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    });
});

function listar() {
    $.post(getURL() + 'plagas/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#plagas").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'id' },
                { data: 'plaga' },
            ]
        });
    });
}