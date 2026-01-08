var table;

$(document).ready(function() {
    if($('table#cultivos').length) {
        listar();
    }

    $('#btnAddCultivo').on('click', function(e) {
        e.preventDefault();
        $("#modal-addCultivo").modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        });
    });

    $('#form-addCultivo').on('submit', function(e) {
        e.preventDefault();
        
        $.post(getURL() + 'cultivos/agregar', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    });
});

function listar() {
    $.post(getURL() + 'cultivos/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#cultivos").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'id' },
                { data: 'cultivo' },
            ]
        });
    });
}