$(document).ready(function() {
    $.ajaxSetup({async: false});

    getSelectData();

    function getSelectData() {
        getProducts();
        getCostCenters();
    }

    function getProducts() {
        $.post(getURL() + 'requisiciones/productos', null, null, 'JSON')
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
        $.post(getURL() + 'requisiciones/centros', null, null, 'JSON')
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

    var table = $('#DetalleProductos').DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info: false, 
        scrollX: true, 
        autoWidth: false, 
        language: {
            url: getURL() + 'assets/plugins/datatables/spanish.json'
        },
        createdRow: function(row, data, dataIndex) {
            $(row).addClass('text-center');
        }
    });

    var counter = 1;

    $('#AgregarProductos').on('submit', function(e) {
        e.preventDefault();
        let form = new FormData(e.target);
        let productname = $('#product option:selected').text();
        let centername = $('#cost_center option:selected').text();
        let unit = getUnit(form.get('product'));

        table.row.add([
            counter,
            form.get('product'),
            productname,
            unit,
            form.get('quantity'),
            form.get('cost_center'),
            centername,
            form.get('observations'),
            '<button class="btn btn-sm btn-danger delete"><i class="fas fa-trash fa-fw"></button>'
        ]).draw('false');


        $('.select2').val(null).trigger('change');
        $('#AgregarProductos')[0].reset();
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
                return;
            } else {
                var json = JSON.stringify(data);
                var observations = $('#observations-document').val();
                var GUID = $('#GUID').val();
                $('#EnviarDocumento').prop('disabled', true);
    
                $.ajax({
                    url: getURL() + 'requisiciones/agregar',
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