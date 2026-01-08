var TableProducts, TableNotes;
let buttonStatus = '';
let DocumentStatus = true;
let DocumentID = document.getElementById('DocumentID').innerHTML;
var AuthMount = 0;

$(document).ready(function() {
    $('#r_caducidad').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

    if($('#state').val() == 'Aceptada') {
        $('#authDocument').addClass('d-none');
        $('#cancelDocument').addClass('d-none');
        $('#exportDocument').addClass('d-none');
    }

    if($('#state').val() == 'Autorizada' || $('#state').val() == 'Autorizada Parcialmente' || $('#state').val() == 'Finalizada') {
        $('#exportDocument').removeClass('d-none');
        $('#authDocument').addClass('d-none');
        $('#confirmAuthDocument').addClass('d-none');
        $('#cancelDocument').addClass('d-none');
    }

    if($('#confirmAuthDocument').is(':disabled')) {
        $('#confirmAuthDocument').addClass('d-none');
    }

    if($('#cancelledBy').length) {
        if(document.getElementById('cancelledBy').innerHTML == 0) {
            $('#cancelInfo').remove();
        } else {
            DocumentStatus = false;
            $('#exportDocument').addClass('d-none');
            $('#authDocument').addClass('d-none');
            $('#cancelDocument').addClass('d-none');
            $('#confirmAuthDocument').addClass('d-none');
        }
    }

    if($('#authBy').length) {
        if(document.getElementById('authBy').innerHTML == 0) {
            $('#authInfo').remove();
        } else {
            DocumentStatus = false;
        }
    }

    if($('#cancelledBy').length || $('#authBy').length) {
        buttonStatus = ' d-none'; 
    } 

    $('#cancelDocument').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Cancelar Solicitud',
            text: 'Este proceso no se podrá revertir',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Iniciar cancelación'
        }).then((result) => {
            if(result.value) {
                $('#modal-cancelDocument').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }
        });
    });

    $('#authDocument').on('click', function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Aceptar documento',
            text: 'Se iniciará el proceso de aceptación del documento',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.value) {
                $.post(getURL() + 'insumos/autorizar-documento/' + DocumentID, null, null, 'JSON')
                .done(function(response) {
                    if(response.status) {
                        window.location.reload();
                    } else {
                        showError(response.code);
                    }
                })
            }
        });
    });

    $('#confirmAuthDocument').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Ingresa tu contraseña para poder autorizar este documento',
            input: 'password',
            showCancelButton: false,
            confirmButtonText: 'Autorizar',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                return fetch(getURL() + 'insumos/confirmar-autorizacion/'+ DocumentID +'/' + password)
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
    })

    $('#exportDocument').on('click', function(e) {
        e.preventDefault();
        let exported = $('#exported').val();
        if(exported == 0) {
            exportar();
        } else {
            Swal.fire({
                title: 'Exportar',
                text: 'El documento ya se encuentra exportado, ¿deseas volverlo a registrar en Comercial?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Exportar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if(result.value) {
                    prepararExportar();
                    exportar();
                }
            })
        }
    });

    function prepararExportar() {
        $.post(getURL() + 'insumos/exportar/' + DocumentID, null, null, 'JSON')
        .done(function(response) {
            if(response.status) {
                console.log("Documento Preparado");
            } 
        })
    }

    function exportar() {
        $.post(getURL() + 'insumos/exportarComercial/' + DocumentID, null, null, 'JSON')
        .done(function(response) {
            if(response.code) {
                let text = response.code;
                let res = text.replace(/[\n\r]/g,'<br>');
                Swal.fire({
                    title: "Resultado",
                    html: res,
                    icon: "info",
                    onClose: () => {
                        window.location.reload();
                    }
                })
            } 
        })
    }

    $('#productos-insumo').on('click', 'button.edit_row', function(e) {
        e.preventDefault();

        $('#r_cost_center').val(null).trigger('change');
        $('#r_depot_id').val(null).trigger('change');
        $('#r_product_id_select').val(null).trigger('change');
        
        let data = TableProducts.row($(this).parents('tr')).data();
        console.log(data);
        
        $('#r_product').text(data.product);
        $('#r_product_id').val(data.product_id);
        $('#r_quantity').val(data.quantity);
        $('#r_uniqid').val(data.uniqid);
        $('#r_lote').val(data.ext_product.LOTE);
        $('#r_caducidad').val(data.ext_product.CADUCIDAD);
        $('#r_observations').text(data.observations);

        let cost = data.cost_center_id;
        let depot_id = data.depot_id;
        let product = data.product_id;

        if(cost > 0) {
            $('#r_cost_center').val(cost).trigger('change');
        }

        if(product > 0) {
            $('#r_product_id_select').val(product).trigger('change')
        }

        if(depot_id > 0) {
            $('#r_depot_id').val(depot_id).trigger('change');
            $('#r_depot_id').trigger('change');
        }

        $("#modal-editRow").modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        });
    });

    $('#form-editRow').on('submit', function(e) {
        e.preventDefault();
        
        $.post(getURL() + 'insumos/editar/partida', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    });

    $('#r_depot_id').on('change', function() {
        let ProductID = $('#r_product_id_select').val();
        let DepotID = $('#r_depot_id').val();

        let form = new FormData();
        form.append('productID', ProductID);
        form.append('depotID', DepotID);

        $.ajax({
            url: getURL() + 'insumos/productos/existencias',
            type: 'POST',
            data: form,
            contentType: false, 
            processData: false,
            dataType: 'JSON',
            success: function(response) {
                if(response.QtyPresent) {
                    if(response.QtyPresent > 0) {
                        $('#r_stock').val(response.QtyPresent);
                        $('#editarFila').prop('disabled', false);
                    } else {
                        $('#r_stock').val('Sin existencia');
                        $('#editarFila').prop('disabled', true);
                    }
                } else {
                    $('#r_stock').val('Sin registro');
                    $('#editarFila').prop('disabled', true);
                }
            }
        });
    });

    $('#productos-insumo').on('click', 'button.auth_row', function(e) {
        e.preventDefault();

        let data = TableProducts.row($(this).parents('tr')).data();

        if(data.depot_id == 0) {
            showError('No ha seleccionado un almacen para esta partida');
        } else {
            Swal.fire({
                title: 'Autorizar',
                text: 'Realizar la autorización de la partida',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Autorizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if(result.value) {
                    let data = TableProducts.row($(this).parents('tr')).data();
                    authRow(data.total, data.uniqid);
                }
            })
        }
    });

    $('#productos-insumo').on('click', 'button.info_row', function(e) {
        e.preventDefault();

        let data = TableProducts.row($(this).parents('tr')).data();

        $('#Producto').text(data.product);
        $('#plaga').val(data.plaga);
        $('#dosis_hectarea').val(data.dosis_hectarea);
        $('#dosis_tambo').val(data.dosis_tambo);
        $('#ph').val(data.ph);
        $('#valvula').val(data.valvula);
        $('#drenaje').val(data.drenaje);
        $('#conductividad').val(data.conductividad);

        $('#modalAdicional').modal('show')
    });

    $('#productos-insumo').on('click', 'button.noauth_row', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Rechazar',
            text: 'Rechazar la partida',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Rechazar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value) {
                let data = TableProducts.row($(this).parents('tr')).data();
                unauthRow(data.uniqid);
            }
        })
    });

    $('#notas-insumo').on('click', 'button.delete_note', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Eliminar nota',
            text: '¿Esta seguro que desea eliminar la nota seleccionada?',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar Nota'
        }).then((result) => {
            if(result.value) {
                let data = TableNotes.row($(this).parents('tr')).data();
                $.post(getURL() + 'insumos/eliminar-nota/' + data.uniqid, null, null, 'JSON')
                .done(function(response) {
                    if(response.status) {
                        window.location.reload();
                    } else {
                        showError(response.code);
                    }
                })
            }
        });
    });

    $('#form-cancelDocument').on('submit', function(e) {
        e.preventDefault();
        let CancelText = $('#cancelText').val();

        $.post(getURL() + 'insumos/cancelar/' + DocumentID, { 'canceltext': CancelText }, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });

    $('#form-addNote').on('submit', function(e) {
        e.preventDefault();
        $('#rn_uniqid').val(DocumentID);
        $.post(getURL() + 'insumos/agregar/nota', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });

    function authRow(total, uniqid) {
        $.post(getURL() + 'insumos/autorizar-fila/' + uniqid, { 'total': total }, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    }

    function unauthRow(uniqid) {
        $.post(getURL() + 'insumos/rechazar-fila/' + uniqid, null, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    }

    $.post(getURL() + 'insumos/productos/' + DocumentID, null, null, 'JSON')
    .done(function(response) {
        TableProducts = $('#productos-insumo').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false, 
            scrollX: true, 
            autoWidth: false, 
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            }, 
            data: response,
            columns: [
                { data: 'quantity', className: 'text-center' }, 
                { data: 'product', className: 'text-truncate' },
                { data: 'unit', className: 'text-center' },
                { data: 'cost_center', className: 'text-center' },
                { data: 'warehouse', className: 'text-center' },
                { data: 'observations' },
                { 
                    data: null, 
                    className: 'text-center',
                    defaultContent: '<button type="button" class="btn btn-xs bg-success auth_row '+buttonStatus+'" title="Autorizar Fila"><i class="fas fa-check fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-primary info_row title="Información de la fila Fila"><i class="fas fa-info-circle fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-warning edit_row '+buttonStatus+'" title="Editar Fila"><i class="fas fa-edit fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-danger noauth_row '+buttonStatus+'" title="Rechazar Fila"><i class="fas fa-times-circle fa-fw"></i></button> ' +
                    ''
                }
            ],
            createdRow: function(row, data, index) {
                if(data.authorized == 1) {
                    $(row).addClass('table-success');
                    $(row).find('button.auth_row button.edit_row').addClass('d-none');
                } else if(data.authorized == 2) {
                    $(row).addClass('table-danger');
                    $(row).find('button.noauth_row button.edit_row').addClass('d-none');
                } 

                if($('#state').val() == 'Pendiente de Autorización' && data.authorized != 0 && data.can_edit_row == 1) {
                    if(data.authorized == 1) {
                        $(row).find('button.noauth_row').removeClass('d-none');
                    } else if(data.authorized == 2) {
                        $(row).find('button.auth_row').removeClass('d-none');
                    }
                }
            }
        });

        $.post(getURL() + 'insumos/notas/' + DocumentID, null, null, 'JSON')
        .done(function(notes) {
            TableNotes = $('#notas-insumo').DataTable({
                paging: false,
                searching: false,
                ordering: false,
                info: false, 
                scrollX: true, 
                autoWidth: false, 
                language: {
                    url: getURL() + 'assets/plugins/datatables/spanish.json'
                }, 
                data: notes,
                columns: [
                    { data: 'date', className: 'text-center text-truncate'},
                    { data: 'note', className: 'text-center text-truncate' },
                    { data: 'fullname', className: 'text-center' },
                    { 
                        data: null,
                        className: 'text-center text-truncate',
                        defaultContent: '<button type="button" class="btn btn-xs bg-danger delete_note '+buttonStatus+'" title="Eliminar Nota"><i class="fas fa-trash-alt fa-fw"></i></button> '
                    }
                ],
                order: [
                    [
                        0, 'desc'
                    ]
                ]
            })
        });

        $.post(getURL() + 'insumos/productos', null, null, 'JSON')
        .done(function(response) {
            $.each(response, function(i, item) {
                $('#r_product_id_select').append($('<option>', {
                    value: item.ProductID,
                    text: item.ProductName
                }))
            });
            $('#r_product_id_select').select2();
        });

        $.post(getURL() + 'insumos/centros', null, null, 'JSON')
        .done(function(response) {
            $.each(response, function(i, item) {
                $('#r_cost_center').append($('<option>', {
                    value: item.CostCenterID,
                    text: item.CostCenterName
                }))
            });
            $('#r_cost_center').select2();
        });

        $.post(getURL() + 'insumos/almacenes', null, null, 'JSON')
        .done(function(response) {
            $.each(response, function(i, item) {
                $('#r_depot_id').append($('<option>', {
                    value: item.DepotID,
                    text: item.DepotName
                }))
            });
            $('#r_depot_id').select2();
        });


    });
});