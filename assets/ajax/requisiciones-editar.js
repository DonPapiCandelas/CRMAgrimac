var TableProducts, TableDocuments, TableNotes;
let buttonStatus = '';
let DocumentStatus = true;
let DocumentID = document.getElementById('DocumentID').innerHTML;
var AuthMount = 0;

$(document).ready(function() {
    $('#r_unit_cost, #r_discount, #r_rate').inputmask({
        mask: '9{1,9}[.99999]'
    });

    if($('#state').val() === 'Pendiente de Autorización') {
        $('#authDocument').addClass('d-none');
        $('#cancelDocument').addClass('d-none');
        $('#rateDocument').addClass('d-none');
        $('#upAttach').addClass('d-none');
        $('#addTimeDocument').addClass('d-none');
        $('#cancelAuth').removeClass('d-none');
    }

    if($('#state').val() === 'Autorizada' || $('#state').val() === 'Autorizada Parcialmente' || $('#state').val() === 'Finalizada') {
        $('#exportDocument').removeClass('d-none');
        $('#authDocument').addClass('d-none');
        $('#cancelDocument').addClass('d-none');
        $('#rateDocument').addClass('d-none');
        $('#upAttach').addClass('d-none');
        $('#addTimeDocument').addClass('d-none');
    }

    if($('#addTimeDocument').is(':disabled')) {
        $('#addTimeDocument').addClass('d-none');
    }

    if($('#confirmAuthDocument').is(':disabled')) {
        $('#confirmAuthDocument').addClass('d-none');
    }


    $('#dtAddTime').datetimepicker({
        inline: true, 
        sideBySide: true,
        locale: 'es-us',
        minDate: new Date()
    });

    if($('#cancelledBy').length) {
        if(document.getElementById('cancelledBy').innerHTML == 0) {
            $('#cancelInfo').remove();
        } else {
            DocumentStatus = false;
            $('#authDocument').addClass('d-none');
            $('#cancelDocument').addClass('d-none');
            $('#rateDocument').addClass('d-none');
            $('#upAttach').addClass('d-none');
            $('#addTimeDocument').addClass('d-none');
            $('#confirmAuthDocument').addClass('d-none');
            $('#exportDocument').addClass('d-none');
        }
    }

    if($('#authBy').length) {
        if(document.getElementById('authBy').innerHTML == 0) {
            $('#authInfo').remove();
        } else {
            DocumentStatus = false;
        }
    }

    if($('#addTimeDocument').is(':enabled') || $('#cancelledBy').length || $('#authBy').length) {
        buttonStatus = ' d-none'; 
    } 

    $('#cancelDocument').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Cancelar Requisición',
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
            title: 'Solicitar autorizacion',
            text: 'Se realizara la solicitud de autorizacion de la requisición',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Solicitar'
        }).then((result) => {
            if(result.value) {
                $.post(getURL() + 'requisiciones/autorizar-documento/' + DocumentID, null, null, 'JSON')
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
                return fetch(getURL() + 'requisiciones/confirmar-autorizacion/'+ DocumentID +'/' + password)
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

    $('#rateDocument').on('click', function(e) {
        e.preventDefault();
        $('#r_rate_uniqid').val(DocumentID);
        $('#r_rate').val(document.getElementById('DocumentRate').innerHTML);
        $('#modal-rateDocument').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });

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

    $('#cancelAuth').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Rechazar solicitud',
            text: 'El documento tiene una solicitud de autorización pendiente, ¿desea rechazar esta solicitud?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Rechazar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value) {
                rechazar();
            }
        })
    });

    function prepararExportar() {
        $.post(getURL() + 'requisiciones/exportar/' + DocumentID, null, null, 'JSON')
        .done(function(response) {
            if(response.status) {
                console.log("Documento Preparado");
            } 
        })
    }

    function exportar() {
        $.post(getURL() + 'requisiciones/exportarComercial/' + DocumentID, null, null, 'JSON')
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

    function rechazar() {
        $.post(getURL() + 'requisiciones/rechazar/' + DocumentID, null, null, 'JSON')
        .done(function(response) {
            if(response.status) {
                window.location.reload();
            } 
        })
    }

    $('#r_unit_cost, #r_discount').on('keyup', function() {
        let quantity, subtotal, unit_cost, discount, tax, tax_percent, taxes, taxes_percent, total, final_total = 0;
        quantity = $('#r_quantity').val();
        discount = $('#r_discount').inputmask('unmaskedvalue');
        unit_cost = $('#r_unit_cost').inputmask('unmaskedvalue');
        tax_percent = $('#r_tax_percent').val();
        taxes_percent = $('#r_other_taxes_percent').val();
        subtotal = parseFloat((quantity * unit_cost) - discount).toFixed(5);
        tax = parseFloat(subtotal * tax_percent).toFixed(5);
        total = parseFloat(parseFloat(subtotal) + parseFloat(tax)).toFixed(5);
        taxes = parseFloat(total * taxes_percent).toFixed(5);
        final_total = parseFloat(parseFloat(total) + parseFloat(taxes)).toFixed(5);

        $('#r_subtotal').val(subtotal);
        $('#r_tax').val(tax);
        $('#r_total').val(total);
    });

    $('#productos-requisicion').on('click', 'button.edit_row', function(e) {
        e.preventDefault();

        $('#r_cost_center').val(null).trigger('change');
        $('#r_provider').val(null).trigger('change');
        $('#r_product_edit').val(null).trigger('change')
        
        let data = TableProducts.row($(this).parents('tr')).data();

        $('#r_requisition_id').val(data.requisition_id);
        $('#r_product').text(data.product);
        $('#r_quantity').val(data.quantity);
        $('#r_unit_cost').val(data.unit_cost);
        $('#r_subtotal').val(parseFloat(data.subtotal - data.discount).toFixed(5));
        $('#r_discount').val(data.discount);
        $('#r_tax').val(data.tax);
        $('#r_other_taxes').val(data.other_taxes);
        $('#r_total').val(data.total);
        $('#r_uniqid').val(data.uniqid);
        $('#r_observations').text(data.observations);
        $('#r_tax_percent').val(data.tax_percent);
        $('#r_other_taxes_percent').val(data.other_taxes);

        let cost = data.cost_center_id;
        let provider = data.provider_id;
        let product_edit = data.product_id

        if(cost > 0) {
            $('#r_cost_center').val(cost).trigger('change');
        }

        if(provider > 0) {
            $('#r_provider').val(provider).trigger('change');
        }

        $('#r_product_edit').val(product_edit).trigger('change');

        $("#modal-editRow").modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        });
    });

    $('#productos-requisicion').on('click', 'button.see_observations', function(e) {
        e.preventDefault();
        
        let data = TableProducts.row($(this).parents('tr')).data();
        
        $('#m_observations').val(data.observations);

        $("#modal-seeObservations").modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        });
    });

    $('#productos-requisicion').on('click', 'button.auth_row', function(e) {
        e.preventDefault();
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
    });

    $('#productos-requisicion').on('click', 'button.noauth_row', function(e) {
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

    $('#productos-requisicion').on('click', 'button.refresh_row', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Reiniciar',
            text: 'Reiniciar la partida',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Reiniciar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value) {
                let data = TableProducts.row($(this).parents('tr')).data();
                cleanRow(data.uniqid);
            }
        })
    });

    $('#documentos-requisicion').on('click', 'button.see_document', function(e) {
        e.preventDefault();
        let data = TableDocuments.row($(this).parents('tr')).data();

        $.ajax({
            url: getURL() + 'requisiciones/ver-documento/' + data.uniqid,
            method: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                let a = document.createElement('a');
                a.setAttribute('target', '_self');
                let url = window.URL.createObjectURL(response);
                a.href = url;
                a.download = data.filename + data.extension;
                a.click();
            }
        })
    });

    $('#documentos-requisicion').on('click', 'button.delete_document', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Eliminar documento',
            text: '¿Esta seguro que desea eliminar el documento adjunto?',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar Documento'
        }).then((result) => {
            if(result.value) {
                let data = TableDocuments.row($(this).parents('tr')).data();
                $.post(getURL() + 'requisiciones/eliminar-documento/' + data.uniqid, null, null, 'JSON')
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

    $('#notas-requisicion').on('click', 'button.delete_note', function(e) {
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
                $.post(getURL() + 'requisiciones/eliminar-nota/' + data.uniqid, null, null, 'JSON')
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

    $('#form-uploadDocument').on('submit', function(e) {
        e.preventDefault();
        let form = new FormData();
        let file = $('#r_file')[0].files[0];
        form.append('file', file);
        form.append('filename', $('#r_filename').val());
        form.append('requisition_id', DocumentID);
        
        $.ajax({
            url: getURL() + 'requisiciones/subir-documento',
            type: 'POST',
            data: form,
            contentType: false, 
            processData: false,
            dataType: 'JSON',
            success: function(response) {
                if(response.status) {
                    window.location.reload();
                } else {
                    showError(response.code);
                }
            }
        });
    });

    $('#form-rateDocument').on('submit', function(e) {
        e.preventDefault();
        $.post(getURL() + 'requisiciones/tipo-cambio', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    });

    $('#form-addTime').on('submit', function(e) {
        e.preventDefault();
        let NewDate = $('#dtAddTime').datetimepicker('viewDate').toString();
        
        $.post(getURL() + 'requisiciones/prorroga/' + DocumentID, { 'newdate': NewDate }, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });

    $('#form-cancelDocument').on('submit', function(e) {
        e.preventDefault();
        let CancelText = $('#cancelText').val();

        $.post(getURL() + 'requisiciones/cancelar/' + DocumentID, { 'canceltext': CancelText }, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });

    $('#form-editRow').on('submit', function(e) {
        e.preventDefault();
        let total = $('#r_total').val();
        if(total <= 0) {
            showError('El total de la partida no puede ser igual o menor a cero');
        } else {
            $.post(getURL() + 'requisiciones/editar/partida', $(this).serialize(), function(response) {
                if(response.status) {
                    window.location.reload();
                } else {
                    showError(response.code);
                }
            }, 'JSON')
        }
    });

    $('#form-addNote').on('submit', function(e) {
        e.preventDefault();
        $('#rn_uniqid').val(DocumentID);
        $.post(getURL() + 'requisiciones/agregar/nota', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });

    function authRow(total, uniqid) {
        $.post(getURL() + 'requisiciones/autorizar-fila/' + uniqid, { 'total': total }, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    }

    function unauthRow(uniqid) {
        $.post(getURL() + 'requisiciones/rechazar-fila/' + uniqid, null, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    }

    function cleanRow(uniqid) {
        $.post(getURL() + 'requisiciones/limpiar-fila/' + uniqid, null, function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    }

    $.post(getURL() + 'requisiciones/productos/' + DocumentID, null, null, 'JSON')
    .done(function(response) {
        TableProducts = $('#productos-requisicion').DataTable({
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
                { data: 'unit_cost', className: 'text-center' },
                { data: 'subtotal', className: 'text-center subtotal' },
                { data: 'discount', className: 'text-center discount' },
                { data: 'tax', className: 'text-center tax' },
                { data: 'other_taxes', className: 'text-center' },
                { data: 'total', className: 'text-center total' },
                { data: 'provider' },
                { 
                    data: null, 
                    className: 'text-center',
                    defaultContent: '<button type="button" class="btn btn-xs bg-success auth_row '+buttonStatus+'" title="Autorizar Fila"><i class="fas fa-check fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-danger noauth_row '+buttonStatus+'" title="Rechazar Fila"><i class="fas fa-times-circle fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-warning edit_row '+buttonStatus+'" title="Editar Fila"><i class="fas fa-edit fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-primary refresh_row '+buttonStatus+'" title="Reiniciar Fila"><i class="fas fa-undo-alt fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-primary see_observations" title="Ver Observaciones"><i class="fas fa-eye fa-fw"></i></button>' +
                    ''
                }
            ],
            createdRow: function(row, data, index) {
                if(data.authorized == 1) {
                    $(row).addClass('table-success');
                    $(row).find('button.auth_row, button.edit_row').addClass('d-none');
                } else if(data.authorized == 2) {
                    $(row).addClass('table-danger');
                    $(row).find('button.noauth_row, button.edit_row').addClass('d-none');
                } else if(data.authorized == 0) {
                    $(row).find('button.see_observations, button.refresh_row').addClass('d-none');
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

        TableProducts.rows('.table-success').every(function() {
            var rows = this.data();
            AuthMount = parseFloat(AuthMount) + parseFloat(rows.total);
        });
        $('#AuthMount').text(parseFloat(AuthMount).toFixed(5));
        
        
        TableProducts.columns('.subtotal').every(function() {
            var subtotal = this
                .data()
                .reduce(function(a,b) {
                    return parseFloat(a) + parseFloat(b);
                });
            $('#DocumentSubtotal').text(parseFloat(subtotal).toFixed(5));
        });

        TableProducts.columns('.discount').every(function() {
            var discount = this
                .data()
                .reduce(function(a,b) {
                    return parseFloat(a) + parseFloat(b);
                });
            $('#DocumentDiscount').text(parseFloat(discount).toFixed(5));
        });

        TableProducts.columns('.tax').every(function() {
            var tax = this
                .data()
                .reduce(function(a,b) {
                    return parseFloat(a) + parseFloat(b);
                });
            $('#DocumentTax').text(parseFloat(tax).toFixed(5));
        });

        TableProducts.columns('.total').every(function() {
            var total = this
                .data()
                .reduce(function(a,b) {
                    return parseFloat(a) + parseFloat(b);
                });
            $('#DocumentTotal').text(parseFloat(total).toFixed(5));
        });

        $.post(getURL() + 'requisiciones/documentos/' + DocumentID, null, null, 'JSON')
        .done(function(documents) {
            TableDocuments = $('#documentos-requisicion').DataTable({
                paging: false,
                searching: false,
                ordering: false,
                info: false, 
                scrollX: true, 
                autoWidth: false, 
                language: {
                    url: getURL() + 'assets/plugins/datatables/spanish.json'
                }, 
                data: documents,
                columns: [
                    {
                        data: 'filetype',
                        className: 'text-center text-truncate',
                        render: function(data, row, index) {
                            return '<i class="fas fa-file-'+ data +' fa-fw"></i>';
                        }                        
                    },
                    { data: 'filename', className: 'text-truncate'},
                    { data: 'fullname', className: 'text-center text-truncate' },
                    { data: 'date', className: 'text-center' },
                    { 
                        data: null,
                        className: 'text-center text-truncate',
                        defaultContent: '<button type="button" class="btn btn-xs bg-primary see_document" title="Ver Documento"><i class="fas fa-file-download fa-fw"></i></button> ' +
                        '<button type="button" class="btn btn-xs bg-danger delete_document '+buttonStatus+'" title="Eliminar Documento"><i class="fas fa-trash-alt fa-fw"></i></button> '
                    }
                ],
                order: [
                    [
                        3, 'desc'
                    ]
                ]
            })
        });

        $.post(getURL() + 'requisiciones/notas/' + DocumentID, null, null, 'JSON')
        .done(function(notes) {
            TableNotes = $('#notas-requisicion').DataTable({
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

        $.post(getURL() + 'requisiciones/centros', null, null, 'JSON')
        .done(function(response) {
            $.each(response, function(i, item) {
                $('#r_cost_center').append($('<option>', {
                    value: item.CostCenterID,
                    text: item.CostCenterName
                }))
            });
            $('#r_cost_center').select2();
        });

        $.post(getURL() + 'requisiciones/proveedores', null, null, 'JSON')
        .done(function(response) {
            $.each(response, function(i, item) {
                $('#r_provider').append($('<option>', {
                    value: item.BusinessEntityID,
                    text: item.Empresa
                }))
            });
            $('#r_provider').select2();
        });

        $.post(getURL() + 'requisiciones/productos', null, null, 'JSON')
            .done(function(response) {
                $.each(response, function(i, item) {
                    $('#r_product_edit').append($('<option>', {
                        value: item.ProductID,
                        text: item.ProductName
                    }))
                });
                $('#r_product_edit').select2();
            });

    });
});