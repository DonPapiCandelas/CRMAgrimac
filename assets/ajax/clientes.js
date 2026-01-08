var table;

$(document).ready(function() {
    if($('table#clientes').length) {
        listar();
    }
});

function listar() {
    $.post(getURL() + 'clientes/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#clientes").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'Empresa' },
                { data: 'Currency', className: 'text-center' },
                { data: 'CreditLimit', className: 'text-center', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                { data: 'ReceptorUsoCFDI', className: 'text-center' },
                { data: 'MetodoPago', className: 'text-center' },
                { data: 'FormaPago', className: 'text-center' }
            ]
        });
    });
}