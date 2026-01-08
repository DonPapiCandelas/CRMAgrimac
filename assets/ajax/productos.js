var table;

$(document).ready(function() {
    if($('table#productos').length) {
        listar();
    }
});

function listar() {
    $.post(getURL() + 'productos/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#productos").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'ProductCode' },
                { data: 'ProductName' },
                { data: 'Category' },
                { data: 'Unit', className: 'text-center' },
                { data: 'Currency', className: 'text-center' },
                { data: 'Price', className: 'text-center', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                { data: 'Cost', className: 'text-center', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                { data: 'Tax', className: 'text-center' }
            ]
        });
    });
}