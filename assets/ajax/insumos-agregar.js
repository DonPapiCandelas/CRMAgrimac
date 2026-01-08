$(document).ready(function() {
    $.ajaxSetup({async: false});

    getSelectData();

    function getSelectData() {
        getProducts();
        getCostCenters();
    }

    function getProducts() {
        $.post(getURL() + 'insumos/productos', null, null, 'JSON')
        .done(function(response) {
            $.each(response, function(i, item) {
                $('#product').append($('<option>', {
                    value: item.ProductID,
                    text: item.ProductName
                }))
            });
            $('#product').select2();
        });
    }

    function getCostCenters() {
        $.post(getURL() + 'insumos/centros', null, null, 'JSON')
        .done(function(response) {
            $.each(response, function(i, item) {
                $('#cost_center').append($('<option>', {
                    value: item.CostCenterID,
                    text: item.CostCenterName
                }))
            });
            $('#cost_center').select2();
        });
    }

    function getUnit(ProductoID) {
        let unidad = null;
        $.post(getURL() + 'productos/' + ProductoID, null, null, 'JSON')
        .done(function(response) {
            unidad = response.Unit;
        });

        return unidad;
    }

    function check() {
        let checkall = true;
        let producto = $('#product option:selected').text();
        let centro = $('#cost_center option:selected').text();
        let cantidad = $('#quantity').val();
        if(producto.length == 0 || centro.length == 0 || cantidad.length == 0) {
            checkall = false;
            showError('Por favor complete todos los campos obligatorios');
            return;
        }
        if(cantidad <= 0) {
            checkall = false;
            showError('La cantidad debe ser mayor a 0');
            return;
        }
        
        if(checkall) {
            $('#modalAdicional').modal('show');
        }
    }

    var table = $('#DetalleProductos').DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info: false, 
        scrollX: true, 
        autoWidth: false, 
        columns: [
            { data: 'Cantidad' },
            { data: 'NombreProducto' },
            { data: 'UnidadMedida' },
            { data: 'CentroCosto' },
            { data: 'Observaciones' },
            { 
                data: null,
                render: function(data, type, row) {
                    return '<button class="btn btn-sm btn-danger delete"><i class="fas fa-trash fa-fw"></button>'
                }
            }
        ],
        language: {
            url: getURL() + 'assets/plugins/datatables/spanish.json'
        },
        createdRow: function(row, data, dataIndex) {
            $(row).addClass('text-center');
        }
    });

    var counter = 1;

    $('#bContinuar').on('click', function() {
        check();
    });

    $('#AgregarProductos').on('submit', function(e) {
        e.preventDefault();
        let form = new FormData(e.target);
        let unidad = getUnit(form.get('product'));
        let data =  new Object();
        data.CodigoProducto = form.get('product');
        data.NombreProducto = $('#product option:selected').text();
        data.UnidadMedida = unidad;
        data.Cantidad = form.get('quantity');
        data.CveCentroCosto = form.get('cost_center');
        data.CentroCosto = $('#cost_center option:selected').text();
        data.Observaciones = form.get('observations');
        data.Plaga = form.get('plaga');
        data.DosisHectarea = form.get('dosis_hectarea');
        data.DosisTambo = form.get('dosis_tambo');
        data.PH = form.get('ph');
        data.Valvula = form.get('valvula');
        data.Drenaje = form.get('drenaje');
        data.Conductividad = form.get('conductividad');

        table.rows.add([data]).draw();

        $('.select2').val(null).trigger('change');
        $('#AgregarProductos')[0].reset();
        $('#modalAdicional').modal('hide');
        counter++;
    });

    $('#DetalleProductos').on('click', 'button.delete', function() {
        table.row($(this).parents('tr')).remove().draw();
    });

    $('#EnviarDocumento').on('click', function() {
        var data = table.rows().data().toArray();
        var justify = $('#justification-document').val();  
        var filas = $("#DetalleProductos > tbody > tr").length;


        if(justify.length == 0) {
            showError('Debes especificar el motivo de la solicitud');
            return;
        } else {
            if(data.length == 0 || filas == 0) {
                showError('No has añadido productos a la solicitud');
            } else {
                var json = JSON.stringify(data);
                var observations = $('#observations-document').val();
                var GUID = $('#GUID').val();
                $('#EnviarDocumento').prop('disabled', true);

                $.ajax({
                    url: getURL() + 'insumos/agregar',
                    type: 'POST',
                    data: {data:json, obvs: observations, justification: justify, guid: GUID},
                    dataType: 'JSON',
                    success: function(response) {
                        if(response.status) {
                            window.location.reload();
                        } else {
                            $('#EnviarDocumento').prop('disabled', false);
                            showError(response.code);
                        }
                    }
                });
            }
        }
    }); 

});