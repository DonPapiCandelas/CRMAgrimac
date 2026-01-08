var table;

$(document).ready(function() {
    if($('table#proveedores').length) {
        listar();
    }
});

function listar() {
    $.post(getURL() + 'proveedores/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#proveedores").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'RFC' },
                { data: 'Empresa' },
                { data: 'Currency', className: 'text-center' },
                { data: 'CreditLimit', className: 'text-center', render: $.fn.dataTable.render.number(',', '.', 0, '$') },
                { data: 'Tax', className: 'text-center' }
            ]
        });
    });
}