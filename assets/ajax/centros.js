var table;

$(document).ready(function() {
    if($('table#centros').length) {
        listar();
    }
});

function listar() {
    $.post(getURL() + 'centros/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#centros").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'CostCenterID', className: 'text-center' },
                { data: 'CostCenterName' }
            ]
        });
    });
}