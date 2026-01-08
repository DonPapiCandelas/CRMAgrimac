var inicio, fin;
var TableReport;
$(document).ready(function() {
    $('.uppercase').keyup(function() {
        this.value = this.value.toUpperCase();
    });

    $.ajaxSetup({async: false});
    getSelectData();

    inicio = moment().startOf('month').format('YYYY-MM-DD');
    fin = moment().endOf('day').format('YYYY-MM-DD');

    $('#modal-report').modal({
        keyboard: false,
        backdrop: 'static',
        focus: true,
        show: true
    })

    $('#reportDate').daterangepicker({
        startDate: moment().startOf('month'),
        endDate: moment().endOf('day'),
        maxDate: moment().endOf('day'),
        autoApply: true,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            daysOfWeek: [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            monthNames: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
        }
    }, function(start, end, label) {
        inicio = start.format('YYYY-MM-DD')
        fin = end.format('YYYY-MM-DD')
    })

    $('#reportDate').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    function getSelectData() {
        getProducts();
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

    $('#form-report').on('submit', function(event) {
        event.preventDefault();

        let form = new FormData();
        form.append('FechaInicio', inicio);
        form.append('FechaFin', fin);
        form.append('Producto', $('#product').val());

        $("#R_FechaInicio").val(inicio);
        $("#R_FechaFinal").val(fin);
        $("#R_Producto").val($("#product").val());

        $.ajax({
            url: getURL() + 'reportes/inocuidad',
            type: 'POST',
            data: form,
            contentType: false, 
            processData: false,
            dataType: 'JSON',
            success: function(response) {
                $('#modal-report').modal('hide');
                TableReport = $('#inocuidad').DataTable({
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
                        {data: 'CostCenterName' },
                        {data: 'DateTransaction', render: function(data, row, index) { return moment(data, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY') } },
                        {data: 'Entrada', class: 'text-center', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                        {data: 'Salida', class: 'text-center', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                        {data: 'Recibio'},
                        {data: 'Entrego' },
                        {data: 'Saldo', class: 'text-center', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                        {
                            data: 'Caducidad', 
                            render: function(data, row, index) {
                                if(data != null) {
                                    return moment(data, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY')
                                } else {
                                    return null;
                                }
                            } 
                        },
                        {data: 'PROVEEDOR' },
                        {data: 'FORMULACION' },
                        {data: 'PRESENTACION' },
                        {data: 'LoteProducto' },
                        {data: 'RSCO' },
                    ]
                });
            }
        });
    });

    $('#form-report-print').on('submit', function(event) {
        event.preventDefault();
        let formPrint = $(this).serialize();
        let formato = $("#R_Formato").val();

        $.ajax({
            async: true,
            url: getURL() + 'libraries/inocuidad.php',
            type: 'POST',
            data: formPrint,
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'html',
            success: function(response) {
                let resultado = JSON.parse(response);
                let $a = $("<a>");
                $a.attr('href', resultado.data);
                $('body').append($a);
                $a.attr('download', 'Reporte_Inocuidad_'+ moment().format('YYYYMMDD-HH_mm_ss') +'.' + formato);
                $a[0].click();
                $a.remove();
            }
        });
    });
});