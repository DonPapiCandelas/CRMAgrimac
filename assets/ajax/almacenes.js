var table;

$(document).ready(function() {
    if($('table#almacenes').length) {
        listar();
    }
});

function listar() {
    $.post(getURL() + 'almacenes/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#almacenes").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'DepotID', className: 'text-center' },
                { data: 'DepotName' }
            ]
        });
    });
}