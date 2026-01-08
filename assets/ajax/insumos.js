var table;

$(document).ready(function() {
    if($('table#insumos').length) {
        listar();
    }

    $('#insumos').on('click', 'button.delrow', function(e) {
        e.preventDefault();
        let data = table.row($(this).parents('tr')).data();

        Swal.fire({
            title: 'Ingresa tu contraseña para poder eliminar este documento',
            input: 'password',
            showCancelButton: false,
            confirmButtonText: 'Autorizar',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                return fetch(getURL() + 'insumos/eliminar-insumo/'+ data.uniqid +'/' + password)
                    .then(response => response.json())
                    .then(data => {
                        if(!data.status) {
                            throw new Error(data.code);
                        }
                        return data;
                    })
                .catch(error => {
                    Swal.showValidationMessage('Request failed: ' + error)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if(result.value.status) {
                window.location.reload();
            }
        });
    });

});

function listar() {
    $.post(getURL() + 'insumos/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#insumos").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'id', className: 'text-center' },
                { data: 'date', className: 'text-center' },
                { data: 'fullname', className: 'text-center' },
                { data: 'authorized_date', className: 'text-center' },
                { data: 'fullnameAuth', className: 'text-center' },
                { data: 'justify' },
                { 
                    data: 'cancelled', 
                    className: 'text-center', 
                    render: function(data, type, row) {
                        return data == 0 ? '<span class="badge bg-success">Vigente</span>' : '<span class="badge bg-danger">Cancelado</span>'
                    }
                },
                { 
                    data: 'state', 
                    className: 'text-center' ,
                    render: function(data, type, row) {
                        return '<span class="badge bg-info">' + data + '</span>';
                    }
                },
                { 
                    data: 'uniqid', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<a href="' + getURL() + 'insumos/editar/' + data + '" class="btn btn-xs bg-primary seebtn"><i class="fas fa-eye"></i> Ver</a> ' +
                        '<button type="button" class="btn btn-xs bg-danger delrow"><i class="fa fa-trash"></i></button>';
                    }
                }
            ],
            order: [
                [
                    0, 'desc'
                ]
            ],
            createdRow: function(row, data, index) {
                if(data.candelete == 0 || data.state == "Pendiente de Autorización" || data.state == "Autorizada" || data.state == "Autorizada Parcialmente" || data.state == "Finalizada") {
                    $(row).find('button.delrow').addClass('d-none');
                }
                if(data.canedit == 0) {
                    $(row).find('a.seebtn').attr('href', getURL() + 'insumos/detalle/' + data.uniqid)
                }
            }
        });
    });
}