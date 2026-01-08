var table;

$(document).ready(function() {
    $('#usa_mex').select2();
    if($('table#dosis').length) {
        listar();
    }

    $('#modal-addDosis').on('hidden.bs.modal', function() {
        $('#producto').val(null).trigger('change');
        $('#cultivo').val(null).trigger('change');
        $('#plaga').val(null).trigger('change');
        $('#usa_mex').val(null).trigger('change');
        $($(this)).find('form')[0].reset();
        $('#control_id').val('0');
    });

    $.post(getURL() + 'cultivos/listar', null, null, 'JSON')
    .done(function(response) {
        $.each(response, function(i, item) {
            $('#cultivo').append($('<option>', {
                value: item.id,
                text: item.cultivo
            }))
        });
        $('#cultivo').select2();
    });

    $.post(getURL() + 'productos/listar', null, null, 'JSON')
    .done(function(response) {
        $.each(response, function(i, item) {
            $('#producto').append($('<option>', {
                value: item.ProductID,
                text: item.ProductName
            }))
        });
        $('#producto').select2();
    });

    $.post(getURL() + 'plagas/listar', null, null, 'JSON')
    .done(function(response) {
        $.each(response, function(i, item) {
            $('#plaga').append($('<option>', {
                value: item.id,
                text: item.plaga
            }))
        });
        $('#plaga').select2();
    });


    $('#btnAddDosis').on('click', function(e) {
        e.preventDefault();
        $("#modal-addDosis").modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        });
    });

    $('table#dosis').on('click', 'button.edit_row', function(e) {
        e.preventDefault();
        $('#producto').val(null).trigger('change');
        $('#cultivo').val(null).trigger('change');
        $('#plaga').val(null).trigger('change');
        $('#usa_mex').val(null).trigger('change');
        
        let data = table.row($(this).parents('tr')).data();
     
        $('#control_id').val(data.id);
        $('#producto').val(data.product_id).trigger('change');
        $('#cultivo').val(data.cultivo_id).trigger('change')
        $('#plaga').val(data.plaga_id).trigger('change');
        $('#intervalo').val(data.intervalo);
        $('#dosis_min').val(data.dosis_min);
        $('#dosis_max').val(data.dosis_max);
        $('#dosis_recomendada').val(data.dosis_recomendada);
        $('#usa_mex').val(data.usa_mex).trigger('change');
        
        $("#modal-addDosis").modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        });
    });

    $('#form-addDosis').on('submit', function(e) {
        e.preventDefault();
        let control = $('#control_id').val();
        let url = control == '0' ? getURL() + 'dosis/agregar' : getURL() + 'dosis/actualizar';
        
        $.post(url, $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON')
    });
});

function listar() {
    $.post(getURL() + 'dosis/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#dosis").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'id', className: 'text-center' },
                { data: 'producto' },
                { data: 'cultivo', className: 'text-center' },
                { data: 'plaga', className: 'text-center' },
                { data: 'intervalo', className: 'text-center' },
                { data: 'dosis_min', className: 'text-center' },
                { data: 'dosis_max', className: 'text-center' },
                { data: 'dosis_recomendada', className: 'text-center' },
                { data: 'usa_mex', className: 'text-center' },
                { 
                    data: null, 
                    className: 'text-center',
                    defaultContent: 
                        '<button type="button" class="btn btn-xs bg-warning edit_row" title="Editar Fila"><i class="fas fa-edit fa-fw"></i></button> ' +
                    ''
                },
            ]
        });
    });
}