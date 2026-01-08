var table;

$(document).ready(function() {
    if($('table#requisiciones').length) {
        listar();
    }
});

function listar() {
    $.post(getURL() + 'requisiciones/listar/requisitador', null, null, 'JSON')
    .done(function(response) {
        table = $("#requisiciones").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'id', className: 'text-center' },
                { data: 'date', className: 'text-center' },
                { data: 'estimated', className: 'text-center' },
                { data: 'authorized_date', className: 'text-center' },
                { data: 'fullname', className: 'text-center' },
                { 
                    data: 'cancelled', 
                    className: 'text-center', 
                    render: function(data, type, row) {
                        return data == 0 ? '<span class="badge badge-success">Vigente</span>' : '<span class="badge badge-danger">Cancelado</span>'
                    }
                },
                { 
                    data: 'state', 
                    className: 'text-center' ,
                    render: function(data, type, row) {
                        return '<span class="badge badge-info">' + data + '</span>';
                    }
                },
                { 
                    data: 'uniqid', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<a href="' + getURL() + 'requisiciones/detalle/' + data + '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Ver</a>';
                    }
                }
            ],
            order: [
                [
                    0, 'desc'
                ]
            ]
        });
    });
}